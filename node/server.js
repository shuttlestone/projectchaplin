io = require('socket.io').listen(1337);
io.sockets.on('connection', function (socket) {
    socket.emit('message', { hello: 'world' });
    socket.on('message', function (data) {
        console.log(data);
    });
    socket.on('frame', function(data) {
        socket.broadcast.emit('frame', {src: data.src, id: socket.id});
    });
    socket.on('disconnect', function() {
        socket.broadcast.emit('client disconnect', {id: socket.id});
    });
});
