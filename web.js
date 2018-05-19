const {enableProdMode} = require('@angular/core');
const express = require('express');
const path = require('path');
const app = express();

const port = process.env.PORT || '8001';

enableProdMode();

app.set('port', port);
app.use(express.static(__dirname + '/src'));
console.log('잘 받아오는거 맞냐');
app.get('/[^\.]+$', function(req, res) {
  console.log(path.join(__dirname, '/src/index.html'));
  res.set('Content-Type', 'text/html')
    .sendFile(path.join(__dirname, '/src/index.html'))
});

app.listen(app.get('port'), function() {
  console.log("Node app is running at localhost:" + app.get('port'))
});
