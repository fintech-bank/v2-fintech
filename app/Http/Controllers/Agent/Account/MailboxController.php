<?php

namespace App\Http\Controllers\Agent\Account;

use App\Helper\MailerFactory;
use App\Http\Controllers\Controller;
use App\Models\Core\Mailbox;
use App\Models\Core\MailboxFolder;
use Auth;
use Illuminate\Http\Request;

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
        //dd($request->segment(4));
        $keyword = $request->get('search');
        $perPage = 15;

        $folders = $this->folders;

        if(empty($folder)) {
            $folder = 'Inbox';
        }

        $messages = $this->getData($keyword, $perPage, $folder);
        $unreadMessages = count(getUnreadMessages());

        return view('agent.account.mailbox.index', compact('folders', 'messages', 'unreadMessages'));
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function show($id)
    {

    }

    public function toggleImportant(Request $request)
    {

    }

    public function trash(Request $request)
    {

    }

    public function getReply($id)
    {

    }

    public function postReply(Request $request, $id)
    {

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
                ->where('mailbox_user_folder.folder_id', $folder->id)
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
}
