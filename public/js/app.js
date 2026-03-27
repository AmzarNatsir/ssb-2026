/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

// require("./bootstrap");
// require('./containers/CreateProject');
// require("./containers/Projects/NewProject");
// require("./containers/Projects/DaftarProject");
// require("./containers/Projects/Upload");
// require("./containers/Projects/UploadForm");
// require("./containers/Customer");
console.log('app.js');
if ('serviceWorker' in navigator) {
  window.addEventListener('load', function() {
    console.log('SW')
      navigator.serviceWorker.register('../service-worker.js');
  });
}
