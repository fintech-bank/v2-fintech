(()=>{function e(e){for(var n=(e+"=".repeat((4-e.length%4)%4)).replace(/\-/g,"+").replace(/_/g,"/"),t=window.atob(n),o=new Uint8Array(t.length),r=0;r<t.length;++r)o[r]=t.charCodeAt(r);return o}!1 in navigator||!1 in window||navigator.serviceWorker.register("/js/sw.js").then((function(){console.log("serviceWorker installed!"),navigator.serviceWorker.ready&&new Promise((function(e,n){var t=Notification.requestPermission((function(n){e(n)}));t&&t.then(e,n)})).then((function(n){if("granted"!==n)throw new Error("We weren't granted permission.");navigator.serviceWorker.ready.then((function(n){var t={userVisibleOnly:!0,applicationServerKey:e("BCntN1CG58GofDtkhmE3SR55uOAvASZ5BscVBbOmEu0_urNBTHpn_HWayYysW5dYSzUEWXxDzWfkgWTlNX-HkzI")};return n.pushManager.subscribe(t)})).then((function(e){console.log("Received PushSubscription: ",JSON.stringify(e)),function(e){var n=document.querySelector("meta[name=csrf-token]").getAttribute("content");fetch("/push",{method:"POST",body:JSON.stringify(e),headers:{Accept:"application/json","Content-Type":"application/json","X-CSRF-Token":n}}).then((function(e){return e.json()})).then((function(e){console.log(e)})).catch((function(e){console.log(e)}))}(e)}))}))})).catch((function(e){console.log(e)}))})();