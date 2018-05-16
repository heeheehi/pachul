const {enableProdMode} = require('@angular/core');
const express = require('express');
const path = require('path');
const app = express();

const port = process.env.PORT || '8001';

enableProdMode();

app.set('port', port);
app.use(express.static(__dirname + '/src'));

app.get('/[^\.]+$', function(req, res) {
  res.set('Content-Type', 'text/html')
    .sendFile(path.join(__dirname, '/src/index.html'))
});

app.listen(app.get('port'), function() {
  console.log("Node app is running at localhost:" + app.get('port'))
});
