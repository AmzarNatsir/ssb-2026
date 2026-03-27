/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

require("./bootstrap");
// use this to swith any active React pages development


// Testing Safety Induction index using memory router
require('./containers/Hse/safetyInduction/router');

// TEMPORARY DISABLED
// require('./containers/Hse/CSinduction');
// END TEMPORARY DISABLED

// require("./containers/Hse/InspectionForm");
// require("./containers/Hse/InspectionList");


// only backup remove later 
// require('./containers/CreateProject');
// require("./containers/Projects/NewProject");
// require("./containers/Projects/DaftarProject");
// require("./containers/Projects/Upload");
// require("./containers/Projects/UploadForm");
// require("./containers/Customer");
// ------------------------------------------------------------

// check SW existence
// if ('serviceWorker' in navigator) {
//   window.addEventListener('load', function() {
//     console.log('SW')
//       navigator.serviceWorker.register('../service-worker.js');
//   });
// }
