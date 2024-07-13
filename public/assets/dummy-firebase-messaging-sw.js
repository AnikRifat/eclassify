importScripts('https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js');

importScripts('https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js');

const firebaseConfig = {
    apiKey: apiKeyValue,
    authDomain: authDomainValue,
    projectId: projectIdValue,
    storageBucket: storageBucketValue,
    messagingSenderId: messagingSenderIdValue,
    appId: appIdValue,
    measurementId: measurementIdValue,
};


if (!firebase.apps.length) {
    firebase.initializeApp(firebaseConfig);
}

const messaging = firebase.messaging();

messaging.setBackgroundMessageHandler(function (payload) {

    let title = payload.data.title;

    let options = {
        body: payload.data.body,
        icon: payload.data.icon,
        data: {
            time: new Date(Date.now()).toString(),
            click_action: payload.data.click_action
        }
    };

    return self.registration.showNotification(title, options);
});

self.addEventListener('notificationclick', function (event) {
    let action_click = event.notification.data.click_action;
    event.notification.close();

    event.waitUntil(
        clients.openWindow(action_click)
    );
});
;
