// Taken from http://farukat.es/journal/2009/04/225-javascript-diggbar-killer-not-blocker
if (top !== self && document.referrer.match(/digg\.com\/\w{1,8}/)) {
  top.location.replace(self.location.href);
}
