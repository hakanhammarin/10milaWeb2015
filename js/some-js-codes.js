if (document.cookie.indexOf("trackedteams") >= 1) {
  // They've been here before.
  console.log("tracked teams");
  console.log("cookie: " + document.cookie.indexOf("trackedteams"));
}
else {
  // set a new cookie
  //expiry = new Date();
  //expiry.setTime(date.getTime()+(10*60*1000)); // Ten minutes

  // Date()'s toGMTSting() method will format the date correctly for a cookie
  //document.cookie = "visited=yes; expires=" ;
  console.log("No Tracked Teams");
};
