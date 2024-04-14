<div class="panel panel-primary" id="supplannel">
   <div class="panel-heading">Origin</div>
  <div class="panel-body" >
      <div class="row">
         

      <div class="col-xs-4">
            
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Origin" id="txtorigin" name= "txtorigin" required="true" >
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
       
          </div>
      </div>
      
        <div class="col-xs-4">
            <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="PTR Number" id="PTRNumber" name= "PTRNumber" required="true" >
            <span class="glyphicon glyphicon-file form-control-feedback"></span>
          </div>
</div>
          <div class="col-xs-4">
            <label>PTR Date</label>
            <input type="date" name="ptrdate" id="ptrdate">
          </div>
   
      </div>


</div>


 <div class="row">
      <div class="col-xs-4">
        
    
      </div>
      
        <div class="col-xs-4">
            
           
       
          </div>



           <div class="col-xs-4">
            

      </div>
      </div>


      </div>


  </div>

<div class="panel panel-primary">
   <div class="panel-heading">Article/Item Details</div>
  <div class="panel-body" >
      <div class="row">
       <div class="col-xs-6">
            
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Fund Source" id="txtsource" name= "txtsource" required="true" readonly="true">
            <span class="glyphicon glyphicon-bookmark form-control-feedback"></span>
       
          </div>
      </div> 
      <div class="col-xs-4"><label>Date Acquired</label>
          <input type="date" name="dtpdateaquired" id="dtpdateaquired">
      </div>

      </div>


      <div class="row">
             <div class="col-xs-6">
            
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Account Title" id="txtaccount" name= "txtaccount" required="true" readonly="true">
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
       
          </div>
      </div>
    
          <div class="col-xs-4">
            
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Article/Item:" id="txtarticle" name= "txtarticle" required="true" readonly="true">
            <span class="glyphicon glyphicon-tag form-control-feedback"></span>
       
          </div>
      </div>
      </div>
      <div class="row">
           <div class="col-xs-6">
             
             <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Estimated Useful Life:" id="txtestimated" name= "txtestimated" required="true" readonly="true" >
            <span class="glyphicon glyphicon-tags form-control-feedback"></span>
       
          </div>
           </div> 
           <div class="col-xs-4">  <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Amount" id="txtamount" name= "txtamount" required="true" >
            <span class="glyphicon glyphicon-ruble form-control-feedback"></span>
       
          </div></div>


      </div>
      <div class="row">
        <div class="col-xs-5">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Description" id="txtdesc" name= "txtdesc" required="true" >
            <span class="glyphicon glyphicon-tasks  form-control-feedback"></span>
        </div>
          </div><div class="col-xs-5">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Property Number" id="txtpropertys" name= "txtpropertys" required="true" >
            <span class="glyphicon glyphicon-th form-control-feedback"></span>
        </div>
          </div>
       
      </div>

       <div class="row">
        <div class="col-xs-5">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Serial" id="txtengine" name= "txtengine" required="true" >
            <span class="glyphicon glyphicon-equalizer form-control-feedback"></span>
        </div>
          </div>
            <div class="col-xs-5">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Chassis Number" id="txtchasis" name= "txtchasis" required="true" >
            <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
        </div>
          </div>
      </div>



      </div>


  </div>

 <ul class="nav nav-tabs responsive-tabs" >
    <li class="active" ><a data-toggle="tab" href="#home"><span class="glyphicon glyphicon-th-list" style="background-color: #337ab7"></span> &nbsp;&nbsp; Property Plants and Equipment to Receive</a></li>
    <li><a data-toggle="tab" href="#menu1" id="tabnewmanual">List of Received Property Plants and Equipment</a></li>
   
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">

      <br/>

      <div class="row">
  <div class="col-xs-6">
      <button class="btn btn-primary" id ="btnmanualtemp"><span class="glyphicon glyphicon-plus"></span>&nbsp;Add</button>
  </div>
    <div class="col-xs-4">
     
  </div>
    <div class="col-xs-2">
      <button class="btn btn-primary" id="btnsavemanualppe"><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;Submit</button>
  </div>  
</div>

      <div class="row">
         <div class="col-xs-12">
           <div >
            <br/>
             <table  class="table table-striped table-condensed" id="tblrichie">
               <thead style="background-color: #337ab7;color:white;">
                <tr>

           

                     <th> Account Title</th>
                     <th>Item</th>
                     <th>Property Number</th>
                    <th>Description</th>
                    <th>Serial/Engine No.</th>
                    <th>Chasis No.</th>
            
                    <th>Usefull Life</th>
                     <th>Units</th> 
                    <th>Amount</th>
                  
                      <th>Remove</th> 
                </tr>
              </thead>
                <tbody id="rcdetails"></tbody>
             </table>
           </div>
         </div>
    </div>
     
    </div>
    <div id="menu1" class="tab-pane fade">
      <div id= "tabrichie"></div>

    </div>
   
 
  </div>


