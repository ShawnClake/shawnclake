// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

var pusher = new Pusher('41637aa0aba7a37edcb1', {
    encrypted: true
});

var channel = pusher.subscribe('useradded');
channel.bind('hi', function(data) {
    console.log("Friend Request Accepted for: " + data.name);
});
