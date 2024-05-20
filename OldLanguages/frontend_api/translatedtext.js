const apiUrl = 'http://localhost:80/api/list';
fetch(apiUrl, {
  method : "GET",
  mode: 'no-cors'})
  .then(response => {
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    return response.json();
  })
  .then(data => {
    console.log(data.data);
  })
  .catch(error => {
    console.error('Error:', error);
  });



  ////////////////////////////////////////
  
