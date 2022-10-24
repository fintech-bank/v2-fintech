/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*************************************!*\
  !*** ./resources/js/enable-push.js ***!
  \*************************************/
function initSW() {
  if (!"serviceWorker" in navigator) {
    //service worker isn't supported
    return;
  } //don't use it here if you use service worker
  //for other stuff.


  if (!"PushManager" in window) {
    //push isn't supported
    return;
  } //register the service worker


  navigator.serviceWorker.register('/js/sw.js').then(function () {
    console.log('serviceWorker installed!');
    initPush();
  })["catch"](function (err) {
    console.log(err);
  });
}

function initPush() {
  if (!navigator.serviceWorker.ready) {
    return;
  }

  new Promise(function (resolve, reject) {
    var permissionResult = Notification.requestPermission(function (result) {
      resolve(result);
    });

    if (permissionResult) {
      permissionResult.then(resolve, reject);
    }
  }).then(function (permissionResult) {
    if (permissionResult !== 'granted') {
      throw new Error('We weren\'t granted permission.');
    }

    subscribeUser();
  });
}

function subscribeUser() {
  navigator.serviceWorker.ready.then(function (registration) {
    var subscribeOptions = {
      userVisibleOnly: true,
      applicationServerKey: urlBase64ToUint8Array('BCntN1CG58GofDtkhmE3SR55uOAvASZ5BscVBbOmEu0_urNBTHpn_HWayYysW5dYSzUEWXxDzWfkgWTlNX-HkzI')
    };
    return registration.pushManager.subscribe(subscribeOptions);
  }).then(function (pushSubscription) {
    console.log('Received PushSubscription: ', JSON.stringify(pushSubscription));
    storePushSubscription(pushSubscription);
  });
}

function urlBase64ToUint8Array(base64String) {
  var padding = '='.repeat((4 - base64String.length % 4) % 4);
  var base64 = (base64String + padding).replace(/\-/g, '+').replace(/_/g, '/');
  var rawData = window.atob(base64);
  var outputArray = new Uint8Array(rawData.length);

  for (var i = 0; i < rawData.length; ++i) {
    outputArray[i] = rawData.charCodeAt(i);
  }

  return outputArray;
}

function storePushSubscription(pushSubscription) {
  var token = document.querySelector('meta[name=csrf-token]').getAttribute('content');
  fetch('/push', {
    method: 'POST',
    body: JSON.stringify(pushSubscription),
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json',
      'X-CSRF-Token': token
    }
  }).then(function (res) {
    return res.json();
  }).then(function (res) {
    console.log(res);
  })["catch"](function (err) {
    console.log(err);
  });
}

initSW();
/******/ })()
;