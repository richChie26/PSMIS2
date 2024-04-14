<html>
    <head>
        <style type="text/css">
            .page-number{
  content: counter(page)
}
            @page {
              size: A4;
              margin: 0; 
            }

            body {
              margin: 0;
            }
        </style>
    </head>
    <body>
      <div class="page-number">
      <?php
     include('btnprintris.php');
      ?>
      </div>
        <script type="text/javascript">
          window.print();
          window.onload = addPageNumbers;

          function addPageNumbers() {
            var totalPages = Math.ceil(document.body.scrollHeight / 1123);  //842px A4 pageheight for 72dpi, 1123px A4 pageheight for 96dpi, 
            for (var i = 1; i <= totalPages; i++) {
              var pageNumberDiv = document.createElement("div");
              var pageNumber = document.createTextNode("Page " + i + " of " + totalPages);
              pageNumberDiv.style.position = "absolute";
              pageNumberDiv.style.top = "calc((" + i + " * (297mm - 0.5px)) - 40px)"; //297mm A4 pageheight; 0,5px unknown needed necessary correction value; additional wanted 40px margin from bottom(own element height included)
              pageNumberDiv.style.height = "16px";
              pageNumberDiv.appendChild(pageNumber);
              document.body.insertBefore(pageNumberDiv, document.getElementById("content"));
              pageNumberDiv.style.left = "calc(100% - (" + pageNumberDiv.offsetWidth + "px + 20px))";
            }
          }
        </script>
        <div id="content">
            Lorem ipsum....
        </div>
    </body>
</html>