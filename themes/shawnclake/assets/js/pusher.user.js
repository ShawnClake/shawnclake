// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

var pusher = new Pusher('41637aa0aba7a37edcb1', {
    encrypted: true
});

var channel = pusher.subscribe('useradded');
channel.bind('tests', function(data) {
    console.log("Friend Request Accepted for: " + data.name);
});

var global = pusher.subscribe('presence-mychannel2');
global.bind('tests', function(data) {
    console.log(data);
});
global.bind('pusher:member_added', function(member) {
    // for example:
    console.log(member.id + " SEPERATOR " + member.info);
});

var privateChannel = pusher.subscribe("private-mychannel");
privateChannel.bind('tests', function(data) {
    console.log("PRIVATE - Friend Request Accepted for: " + data.name);
});