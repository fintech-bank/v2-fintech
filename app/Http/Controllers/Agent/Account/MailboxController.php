<?php

namespace App\Http\Controllers\Agent\Account;

use App\Events\Mailbox\ReceiverMailbox;
use App\Helper\LogHelper;
use App\Helper\MailerFactory;
use App\Http\Controllers\Controller;
use App\Models\Core\Mailbox;
use App\Models\Core\MailboxAttachment;
use App\Models\Core\MailboxFlags;
use App\Models\Core\MailboxFolder;
use App\Models\Core\MailboxReceiver;
use App\Models\Core\MailboxTmpReceiver;
use App\Models\Core\MailboxUserFolder;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class MailboxController extends Controller
{
    protected $mailer;
    protected $folders = [];

    public function __construct(MailerFactory $mailer)
    {
        $this->mailer = $mailer;
        $this->getFolders();
    }

    public function index(Request $request, $folder = "")
    {
        if($request->segment(4) == 'create') {
            $folders = $this->folders;
            $unreadMessages = count(getUnreadMessages());

            $users = User::where('id', '!=', auth()->user()->id)->get();

            return view('agent.account.mailbox.create', compact('folders', 'unreadMessages', 'users'));
        } elseif ($request->segment(4) != 'message') {
            $keyword = $request->get('search');
            $perPage = 15;

            $folders = $this->folders;

            if(empty($folder)) {
                $folder = 'Inbox';
            }

            $messages = $this->getData($keyword, $perPage, $folder);
            $unreadMessages = count(getUnreadMessages());

            return view('agent.account.mailbox.index', compact('folders', 'messages', 'unreadMessages'));
        } else {
            $folders = $this->folders;
            $unreadMessages = count(getUnreadMessages());
            $mailbox = Mailbox::find($request->segment(5));
//        $folder = $mailbox->userFolder()->folder()->first();
            // if this message from "Inbox" then set is_unread=0
            if(($flag = $mailbox->flag()) && isset($flag->is_unread) && $flag->is_unread == 1) {
                $flag->is_unread = 0;
                $flag->save();
            }
            return view('agent.account.mailbox.show', [
                'mailbox' => $mailbox,
                'unreadMessages' => $unreadMessages,
                'folders' => $folders
            ]);
        }

    }

    public function create()
    {
        $folders = $this->folders;
        $unreadMessages = count(getUnreadMessages());

        $users = User::where('id', '!=', auth()->user()->id)->get();

        return view('agent.account.mailbox.create', compact('folders', 'unreadMessages', 'users'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $receivers = [];

        foreach ($request->get('receiver_id') as $receiver) {
            $ctn = json_decode($receiver, true);
            $receivers[] = [$ctn[0]['value']];
        }


        try {
            $this->validate($request, [
                'subject' => 'required',
                'receiver_id' => 'required',
                'body' => 'required'
            ]);
        } catch (ValidationException $e) {
            dd($e);
        }

        try {
            $this->validateAttachments($request);
        }catch (\Exception $ex) {
            LogHelper::notify('critical', $ex);
            return redirect()->back()->with('flash_error', $ex->getMessage());
        }

        $receiver_ids = $receivers;
        $submit = $request->get('submit');

        $mailbox = new Mailbox();

        $mailbox->subject = $request->get('subject');
        $mailbox->body = $request->get('body');
        $mailbox->sender_id = auth()->user()->id;
        $mailbox->time_sent = date('Y-m-d H:i:s');
        $mailbox->parent_id = 0;

        $mailbox->save();

        $this->save($submit, $receiver_ids, $mailbox);

        $this->uploadAttachments($request, $mailbox);

        if($request->get('submit') == 1) {
            $this->mailer->sendMailboxEmail($mailbox);
            broadcast(new ReceiverMailbox($mailbox));

            return redirect()->back()->with('success', 'Message Envoyer');
        } else {
            return redirect()->back()->with('success', "Message enregistrer en brouillon");
        }


    }

    public function show($id)
    {
        $folders = $this->folders;
        $unreadMessages = count(getUnreadMessages());
        $mailbox = Mailbox::find($id);
//        $folder = $mailbox->userFolder()->folder()->first();
        // if this message from "Inbox" then set is_unread=0
        if(($flag = $mailbox->flag()) && isset($flag->is_unread) && $flag->is_unread == 1) {
            $flag->is_unread = 0;
            $flag->save();
        }
        return view('agent.account.mailbox.show', compact('folders', 'unreadMessages', 'mailbox'));
    }

    public function toggleImportant(Request $request)
    {
        if(!$request->mailbox_flag_ids || count($request->mailbox_flag_ids) == 0)
            return response()->json(['state' => 0, 'msg' => 'required mailbox_flag_ids'], 500);

        $updated = [];

        foreach ($request->mailbox_flag_ids as $id) {
            $mailbox_flag = MailboxFlags::find($id);
            $mailbox_flag->is_important = ($mailbox_flag->is_important==0?1:0);
            $mailbox_flag->save();
            $updated[] = $mailbox_flag;
        }

        return response()->json(['state' => 1, 'msg' => 'Mis à jour avec succès', 'updated' => $updated], 200);
    }

    public function trash(Request $request)
    {
        if(!$request->mailbox_user_folder_ids || count($request->mailbox_user_folder_ids) == 0)
            return response()->json(['state' => 0, 'msg' => 'required mailbox_user_folder_id'], 500);

        $updated = [];
        $trashFolder = MailboxFolder::where('title', 'Trash')->first();
        foreach ($request->mailbox_user_folder_ids as $id) {
            $mailbox_user_folder = MailboxUserFolder::find($id);
            $mailbox_user_folder->folder_id = $trashFolder->id;
            $mailbox_user_folder->save();
            $updated[] = $mailbox_user_folder;
        }
        return response()->json(['state' => 1, 'msg' => 'Messages déplacés vers le dossier de la corbeille', 'updated' => $updated], 200);
    }

    public function getReply($id)
    {
        $mailbox = Mailbox::find($id);
        $folders = $this->folders;
        $unreadMessages = count(getUnreadMessages());
        return view('agent.account.mailbox.reply', compact('folders', 'unreadMessages', 'mailbox'));
    }

    public function postReply(Request $request, $id)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);

        try {
            $this->validateAttachments($request);
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }

        $old_mailbox = Mailbox::find($id);
        $mailbox = new Mailbox();
        $mailbox->subject = Str::start($old_mailbox->subject, "RE:")?$old_mailbox->subject:"RE: " . $old_mailbox->subject;
        $mailbox->body = $request->body;
        $mailbox->sender_id = Auth::user()->id;
        $mailbox->time_sent = date("Y-m-d H:i:s");
        $mailbox->parent_id = $old_mailbox->id;
        $mailbox->save();

        $receiver_ids = [$old_mailbox->sender_id];

        $this->save(1, $receiver_ids, $mailbox);

        // save attachments if found
        $this->uploadAttachments($request, $mailbox);
        // send email
        $this->mailer->sendMailboxEmail($mailbox);

        return redirect()->back()->with('success', 'Réponse envoyer');
    }

    public function getForward($id)
    {

    }

    public function postForward(Request $request, $id)
    {

    }

    public function send($id)
    {

    }

    private function getFolders(): void
    {
        $this->folders = MailboxFolder::all();
    }

    private function getData($keyword, $perPage, $foldername)
    {
        $folder = MailboxFolder::where('title', $foldername)->first();

        if($foldername == "Inbox") {

            $query = Mailbox::join('mailbox_receiver', 'mailbox_receiver.mailbox_id', '=', 'mailbox.id')
                ->join('mailbox_user_folder', 'mailbox_user_folder.user_id', '=', 'mailbox_receiver.receiver_id')
                ->join('mailbox_flags', 'mailbox_flags.user_id', '=', 'mailbox_user_folder.user_id')
                ->where('mailbox_receiver.receiver_id', Auth::user()->id)
                ->where('mailbox_user_folder.folder_id', $folder->id)
                ->where('sender_id', '!=', Auth::user()->id)
//                    ->where('parent_id', 0)
                ->whereRaw('mailbox.id=mailbox_receiver.mailbox_id')
                ->whereRaw('mailbox.id=mailbox_flags.mailbox_id')
                ->whereRaw('mailbox.id=mailbox_user_folder.mailbox_id')
                ->select(["*", "mailbox.id as id", "mailbox_flags.id as mailbox_flag_id", "mailbox_user_folder.id as mailbox_folder_id"]);
        } else if ($foldername == "Sent" || $foldername == "Drafts") {
            $query = Mailbox::join('mailbox_user_folder', 'mailbox_user_folder.mailbox_id', '=', 'mailbox.id')
                ->join('mailbox_flags', 'mailbox_flags.user_id', '=', 'mailbox_user_folder.user_id')
                ->where('mailbox_user_folder.folder_id', $folder->id)
                ->where('mailbox_user_folder.user_id', Auth::user()->id)
//                ->where('parent_id', 0)
                ->whereRaw('mailbox.id=mailbox_flags.mailbox_id')
                ->whereRaw('mailbox.id=mailbox_user_folder.mailbox_id')
                ->select(["*", "mailbox.id as id", "mailbox_flags.id as mailbox_flag_id", "mailbox_user_folder.id as mailbox_folder_id"]);
        } else {
            $query = Mailbox::join('mailbox_user_folder', 'mailbox_user_folder.mailbox_id', '=', 'mailbox.id')
                ->join('mailbox_flags', 'mailbox_flags.user_id', '=', 'mailbox_user_folder.user_id')
                ->leftJoin('mailbox_receiver', 'mailbox_receiver.mailbox_id', '=', 'mailbox.id')
                ->where(function ($query) {
                    $query->where('mailbox_user_folder.user_id', Auth::user()->id)
                        ->orWhere('mailbox_receiver.receiver_id', Auth::user()->id);
                })
                ->where('mailbox_user_folder.folder_id', $folder->id ?? 1)
//                ->where('parent_id', 0)
                ->whereRaw('mailbox.id=mailbox_flags.mailbox_id')
                ->whereRaw('mailbox.id=mailbox_user_folder.mailbox_id')
                ->whereRaw('mailbox_user_folder.user_id!=mailbox_receiver.receiver_id')
                ->select(["*", "mailbox.id as id", "mailbox_flags.id as mailbox_flag_id", "mailbox_user_folder.id as mailbox_folder_id"]);
        }


        if (!empty($keyword)) {
            $query->where('subject', 'like', "%$keyword%");
        }

        $query->orderBy('mailbox.id', 'DESC');

        $messages = $query->paginate($perPage);

        return $messages;
    }

    /**
     * validateAttachments
     *
     *
     * @param $request
     * @throws \Exception
     */
    private function validateAttachments($request)
    {
        $check = [];
        if($request->hasFile('attachments')) {
            $allowedfileExtension = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'txt', 'xls', 'xlsx', 'odt', 'dot', 'html', 'htm', 'rtf', 'ods', 'xlt', 'csv', 'bmp', 'odp', 'pptx', 'ppsx', 'ppt', 'potm'];
            $files = $request->file('attachments');
            foreach ($files as $file) {
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                if(!in_array($extension, $allowedfileExtension)) {
                    $check[] = $extension;
                }
            }
        }
        if(count($check) > 0) {
            throw new \Exception("Un ou plusieurs fichiers contiennent des extensions non valides: ". implode(",", $check));
        }
    }

    /**
     * save
     *
     *
     * @param $submit
     * @param $receiver_ids
     * @param $mailbox
     */
    private function save($submit, $receiver_ids, $mailbox)
    {
        // We will save two records in tables mailbox_user_folder and mailbox_flags
        // for both the sender and the receivers
        // For the sender perspective the message will be in the "Sent" folder
        // For the receiver perspective the message will be in the "Inbox" folder
        // 1. The sender
        // save folder as "Sent" or "Drafts" depending on button
        $mailbox_user_folder = new MailboxUserFolder();
        $mailbox_user_folder->mailbox_id = $mailbox->id;
        $mailbox_user_folder->user_id = $mailbox->sender_id;
        // if click "Draft" button save into "Drafts" folder
        if($submit == 2) {
            $mailbox_user_folder->folder_id = MailboxFolder::where("title", "Drafts")->first()->id;
        } else {
            $mailbox_user_folder->folder_id = MailboxFolder::where("title", "Sent")->first()->id;
        }
        $mailbox_user_folder->save();
        // save flags "is_unread=0"
        $mailbox_flag = new MailboxFlags();
        $mailbox_flag->mailbox_id = $mailbox->id;
        $mailbox_flag->user_id = $mailbox->sender_id;;
        $mailbox_flag->is_unread = 0;
        $mailbox_flag->is_important = 0;
        $mailbox_flag->save();
        // 2. The receivers
        // if there are receivers and sent button clicked then save into flags, folders and receivers
        if($submit == 1) {
            foreach ($receiver_ids as $receiver_id) {
                // save receiver
                $mailbox_receiver = new MailboxReceiver();
                $mailbox_receiver->mailbox_id = $mailbox->id;
                $mailbox_receiver->receiver_id = $receiver_id[0];
                $mailbox_receiver->save();
                // save folder as "Inbox"
                $mailbox_user_folder = new MailboxUserFolder();
                $mailbox_user_folder->mailbox_id = $mailbox->id;
                $mailbox_user_folder->user_id = $receiver_id[0];
                $mailbox_user_folder->folder_id = MailboxFolder::where("title", "Inbox")->first()->id;
                $mailbox_user_folder->save();
                // save flags "is_unread=1"
                $mailbox_flag = new MailboxFlags();
                $mailbox_flag->mailbox_id = $mailbox->id;
                $mailbox_flag->user_id = $receiver_id[0];
                $mailbox_flag->is_unread = 1;
                $mailbox_flag->save();
            }
        } else {
            // save into tmp receivers
            foreach ($receiver_ids as $receiver_id) {
                // save receiver
                $mailbox_receiver = new MailboxTmpReceiver();
                $mailbox_receiver->mailbox_id = $mailbox->id;
                $mailbox_receiver->receiver_id = $receiver_id[0];
                $mailbox_receiver->save();
            }
        }
    }

    /**
     * uploadAttachments
     *
     *
     * @param $request
     * @param $mailbox
     */
    private function uploadAttachments($request, $mailbox)
    {
        checkDirectory("documents");
        $destination = public_path('uploads/mailbox/');
        if($request->hasFile('attachments')) {
            $files = $request->file('attachments');
            foreach ($files as $file) {
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $new_name = pathinfo($filename, PATHINFO_FILENAME) . '-' . time().'.'.$extension;
                $file->move($destination, $new_name);
                $attachment = new MailboxAttachment();
                $attachment->mailbox_id = $mailbox->id;
                $attachment->attachment = $new_name;
                $attachment->save();
            }
        }
    }
}
