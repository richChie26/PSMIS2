<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8" />
	<title>Convert Excel to HTML Table using JavaScript</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
<!--     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<!-- <script src="ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
</head>
<body>
    <div class="container">
    	<h2 class="text-center mt-4 mb-4"></h2>
    	<div class="card">
    		<div class="card-header"><b>Select Excel File</b></div>
    		<div class="card-body">
    			
                <input type="file" id="excel_file" />

<button id="btnuploadspos" class="btn btn-primary" style="float: right;">Submit</button>
<br/><br/>
    		</div>
    	</div>
        <div id="excel_data" class="mt-5"></div>
    </div>



</body>
</html>
        <script type="text/javascript">
            $(document).ready(function(){
                $(document).on("click","#btnuploadspos",function(e){
                    e.preventDefault();
                     $("#btnuploadspos").prop('disabled', true);
                    var tb = $('.layui-table:eq(0) tbody');
                    var size = tb.find("tr").length;
                    var mysize =[];
                    var chie0 = [];
                    var chie1 = [];
                    var i  = 0;



                    var tb = $('.layui-table:eq(0) tbody');
                    var size = tb.find("tr").length;
                    console.log("Number of rows : " + size);
                    tb.find("tr").each(function(index, element) {
                        var colSize = $(element).find('td').length;
                    
                        $(element).find('td').each(function(index, element) {
                        var colVal = $(element).text();
                    //    console.log( colVal.trim());

                        chie0.push(colVal);


                        });

  });
  // alert(chie0);

                    $.ajax({
                    url:'saveuploadposition.php',
                    type:'get',
                    data:{chie0:chie0},
                    cache:false,
                    success:function(response){
                        //  alert(response);
                        if(response == 1){
                            // alert(response);
                            //  $("#A0011").trigger("click");        

                          
                            var strform = ' <div class="panel panel-primary">'+
                                '<div class="panel-heading">Plantilla Position</div>'+
                                '<div class="panel-body" id="frmmodalbody">'+
                                ' <div id="mnudetails"></div> </div> </div></div>';

                                $("#richiedetails").html(strform);


                                $.ajax({
                                    url:'A0011.php',
                                    cache:false,
                                    type:'get',
                                    success:function(data){
                                    $("#frmmodalbody").html(data);
                                    $.ajax({
                                            url:'positiondetails.php',
                                            data:{txtsections:""},
                                            cache:false,
                                            success:function(data){
                                            
                                            $("#rcdetails").html(data);
                                            }
                                        })
                                    }
                                })
                                alert("Upload successfull");
                            $("#btnuploadspos").prop('disabled', false);
                        }
                    }
                    })


                })
            })
        </script>
<script>

const excel_file = document.getElementById('excel_file');

excel_file.addEventListener('change', (event) => {

    if(!['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'].includes(event.target.files[0].type))
    {
        document.getElementById('excel_data').innerHTML = '<div class="alert alert-danger">Only .xlsx or .xls file format are allowed</div>';

        excel_file.value = '';

        return false;
    }

    var reader = new FileReader();

    reader.readAsArrayBuffer(event.target.files[0]);

    reader.onload = function(event){

        var data = new Uint8Array(reader.result);

        var work_book = XLSX.read(data, {type:'array'});

        var sheet_name = work_book.SheetNames;

        var sheet_data = XLSX.utils.sheet_to_json(work_book.Sheets[sheet_name[0]], {header:1});

        if(sheet_data.length > 0)
        {
            var table_output = '<table class="table table-striped table-bordered layui-table" id="tblgwapo">';

            for(var row = 0; row < sheet_data.length; row++)
            {


                table_output += '<tr>';

                    if(row == 0){
                         for(var cell = 0; cell < sheet_data[row].length; cell++)
                {

                    if(row == 0)
                    {

                        table_output += '<th>'+sheet_data[row][cell]+'</th>';

                    }
                  

                }
                  // table_output  += '</tr><tbody>';  
                    }else{
                        // table_output  += '<tr>';
                         for(var cell = 0; cell < sheet_data[row].length; cell++)
                {

                    if(row == 0)
                    {

                        table_output += '<th>'+sheet_data[row][cell]+'</th>';

                    }
                    else
                    {

                        table_output += '<td class ="chie'+cell+'" >' + sheet_data[row][cell] +'</td>';

                    }

                }
                    }

                table_output += '</tr>';

            }

            table_output += '</tbody></table>';

            document.getElementById('excel_data').innerHTML = table_output;
        }

        excel_file.value = '';

    }

});

</script>