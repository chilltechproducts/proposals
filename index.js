

var geolocation = require('geolocation')
var io = require('socket.io')(3000);

io.on('connection', function(socket){
    socket.on('getLocation', function(){
        geolocation.getCurrentPosition(function (err, position) {
        if (err) throw err
        console.log(position)
        
        })
    })  
})
