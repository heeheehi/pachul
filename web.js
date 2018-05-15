var express = require('express');
var path = require('path');
var app = express();

const port = process.env.PORT || '8001';

app.set('port', port);
app.use(express.static(__dirname + '/src'));

app.get('/[^\.]+$', function(req, res) {
  res.set('Content-Type', 'text/html')
    .sendFile(path.join(__dirname, '/src/index.html'))
});

app.listen(app.get('port'), function() {
  console.log("Node app is running at localhost:" + app.get('port'))
});
