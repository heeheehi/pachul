const {enableProdMode} = require('@angular/core');
const {ngExpressEngine} = require('@nguniversal/express-engine');
const express = require('express');
const path = require('path');
const app = express();

const port = process.env.PORT || '8001';
const {PCAppServerModuleNgFactory} = require('../../../dist/dpachul/main');
const pwd = (process.env.exec_mode === 'cluster') ? './' : path.join(__dirname);

enableProdMode();

app.set('port', port);
app.set('view engine', 'html');
app.use('/', express.static(pwd, {index: false}));

app.use(express.static(__dirname + '/src'));

app.get('/[^\.]+$', function(req, res) {
  res.set('Content-Type', 'text/html')
    .sendFile(path.join(__dirname, '/src/index.html'))
});

app.engine('html', ngExpressEngine({
  bootstrap: PCAppServerModuleNgFactory,
  providers: []
}));

app.listen(app.get('port'), function() {
  console.log("Node app is running at localhost:" + app.get('port'))
});
