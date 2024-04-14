<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
<body>
<table cellspacing="0" cellpadding="0" border="0" class="layui-table">
  <tbody>
    <tr data-index="0" class="">
      <td data-field="sid" data-content="123456">
        <div class="layui-table-cell laytable-cell-1-sid"> 123456 </div>
      </td>
      <td>
        <div></div>
      </td>
    </tr>
    <tr data-index="1" class="">
      <td data-field="sid" data-content="100012">
        <div class="layui-table-cell laytable-cell-1-sid"> 100012 </div>
      </td>
      <td>
        <div>ssss</div>
      </td>
    </tr>
  </tbody>
</table>
<script type="text/javascript">
	$("document").ready(function() {
  var tb = $('.layui-table:eq(0) tbody');
  var size = tb.find("tr").length;
  var val = [];
  console.log("Number of rows : " + size);
  tb.find("tr").each(function(index, element) {
    var colSize = $(element).find('td').length;
    // console.log("  Number of cols in row " + (index + 1) + " : " + colSize);
    $(element).find('td').each(function(index, element) {
      var colVal = $(element).text();
      console.log("    Value in col " + (index + 1) + " : " + colVal.trim());

      // val(index) = colVal.trim();  
    });
  });
});
</script>
</body>
</html>