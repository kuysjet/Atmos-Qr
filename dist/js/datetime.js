function updateClock() {
  var now = new Date();
  var days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']; // Abbreviated day names
  var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
  
  var dayOfWeek = days[now.getDay()]; // Get abbreviated day name
  var month = months[now.getMonth()];
  var date = now.getDate();
  var year = now.getFullYear();
  
  var hours = now.getHours();
  var minutes = now.getMinutes();
  var seconds = now.getSeconds();
  
  // Determine whether it's AM or PM
  var meridiem = hours < 12 ? 'AM' : 'PM';
  
  // Convert hours to 12-hour format
  hours = hours % 12 || 12;
  
  // Pad single digit hours, minutes, and seconds with leading zeros
  hours = hours < 10 ? "0" + hours : hours;
  minutes = minutes < 10 ? "0" + minutes : minutes;
  seconds = seconds < 10 ? "0" + seconds : seconds;
  
  // Format the time as HH:MM:SS AM/PM
  var timeString = hours + ":" + minutes + ":" + seconds + ' ' + meridiem;
  
  // Update the Philippine Standard Time display
  document.getElementById('philippine-date-time').innerHTML = dayOfWeek + ', ' + month + ' ' + date + ', ' + year + ' ' + timeString;
  
  // Update the clock every second
  setTimeout(updateClock, 1000);
}

// Call the function for the first time to start the clock
updateClock();