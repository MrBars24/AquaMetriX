var c = function(){

}
c.connected = function(callback){
  window.addEventListener('online',callback);
}
c.disconnected = function(callback){
  window.addEventListener('offline',callback); 
}
c.statusChange = function(obj){
  window.addEventListener('online',obj.onConnect);
  window.addEventListener('offline',obj.onDisconnect);
}
c.isConnected = function(){
  return navigator.onLine;
}
window.ConnectJS = c;
if(!window.$$){
  window.$$ = c;
}