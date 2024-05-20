<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Modal</title>
  <link rel="stylesheet" href="modal.css"> 
</head>
<body>

  <div id="myModal" class="modal">
    <span class="close" onclick="closeModal()">&times;</span>
    <img class="modal-content" id="modalImg">
  </div>

  <script>
    function closeModal() {
      document.getElementById("myModal").style.display = "none";
    }

   
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('image')) {
      var imageSrc = decodeURIComponent(urlParams.get('image'));
      document.getElementById("modalImg").src = "img/" + imageSrc;
      document.getElementById("myModal").style.display = "block";
    }

    window.onclick = function(event) {
      var modal = document.getElementById('myModal');
      if (event.target == modal) {
        closeModal();
      }
    };
  </script>

</body>
</html>
