require('./bootstrap');
// Make all functions inside 'vinylShop.js' that start with 'export' accessible inside the HTML pages
window.vinylShop = require('./vinylShop');
// Run the hello() function
vinylShop.hello();
// Run the to_mm_ss() function
vinylShop.to_mm_ss();
