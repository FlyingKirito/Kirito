function connect() {
    wsServer = 'ws://127.0.0.1:9371';
    websocket = new WebSocket(wsServer);

    websocket.onopen = function (evt) {
        console.log("Connected to WebSocket server.");
        // start();
    };

    websocket.onclose = function (evt) {
        console.log("Server closed");
        // connect();
    };

    websocket.onmessage = function (evt) {
        $("div").append(evt.data+"<br>");
        console.log(evt.data);
        // reset();
    };

    websocket.onerror = function (evt, e) {
        console.log('Error occured: ' + evt.data);
    };
}

connect()

$("button").click(function () {
    var value = $("input").val();
    if (value.length > 0) {
        doSend(value);
    }
});

function doSend (msg) {
    websocket.send(msg);
}
