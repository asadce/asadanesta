//var $ = jQuery;
//
//
//$(document).ready(function(){
//    /* CHeck For Listings */
//    var listingFound = $('.directorist-dashboard-listings-tbody td').html();
//    console.log("log " + listingFound);
//      
//    /* Check For Order */
//
//    var orderFound =  $('#manage_invoices .atbd_manage_fees_wrapper p').html();
//    console.log("log " + orderFound);
//    
///* No orders and No Listing */    
//if (listingFound == "No items found" && orderFound == "No order found!"){
//    console.log("No orders and No Listing");
//    console.log("Order: " + orderFound + " Listing: " + listingFound);
//     $(".directorist-btn--add-listing").attr('href', '/add-listing');
//    $(".directorist-btn--add-listing").css({"visibility":"visible"});
//    }
///* Order Found but No Listing */
//if (orderFound != "No order found!" && listingFound == "No items found"){
//        console.log("Order Found but No Listing");
//    console.log("Order: " + orderFound + " Listing: " + listingFound);
//        $(".directorist-btn--add-listing").attr('href', '/add-listing-form');
//        $(".directorist-btn--add-listing").css({"visibility":"visible"});
//    }
///* Order Found and Listing Found    */
//if (orderFound != "No order found!" && listingFound != "No items found") {
//    console.log("Order Found and Listing Found")
//    console.log("Order: " + orderFound + " Listing: " + listingFound);
//        $('.directorist-btn--add-listing').css('display', 'none');
//        
//    }
//});