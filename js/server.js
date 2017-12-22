var aio = require('asterisk.io'),
    ami = null;
var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);

app.get('/', function(req, res) {
   res.sendfile('index.html');
});

//Whenever someone connects this gets executed
io.on('connection', function(socket) {
   console.log('A user connected');

   //Whenever someone disconnects this piece of code executed
   socket.on('disconnect', function () {
      console.log('A user disconnected');
   });
});

 
ami = aio.ami(
    'localhost',   // Asterisk PBX machine 
 
    5038,               // the default port number setup 
                        // in "/etc/asterisk/manager.conf" 
                        // in "general" section 
 
    'admin',            // manager username 
 
    '1234'             // manager password 
);

ami.on('eventRegistry', function(data){
    console.log('Registry', data);
	io.sockets.emit('event', data);
});

http.listen(3000, function() {
   console.log('listening on *:3000');
});
