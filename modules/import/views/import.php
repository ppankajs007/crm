<style>
.tooltip {
  position: relative;
  display: inline-block;
  border-bottom: 1px dotted black;
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: 120px;
  background-color: black;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;
  position: absolute;
  z-index: 1;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
}
</style>
<div class="container-fluid"> <!-- start page title -->
  <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>">CRM</a></li>
                        <li class="breadcrumb-item active">Import</li>
                    </ol>
                </div>
                <h4 class="page-title">Import</h4>
            </div>
        </div>
        
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                  <div class="row mb-2">
                        <div class="col-sm-12">
                          <form method="post" action="import/ImportMsi" enctype="multipart/form-data">
                            <input type="file" name="file_upload">
                            <input type="submit" class="btn btn-success" name="submit" value="Import MSI">
                          </form>
                        </div><!-- end col-->
                    </div>
                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div><!-- end col-->

    
        <div class="col-6">
          <div class="card">
            <div class="card-body">
              <div class="row mb-2">
                <div class="col-sm-12">
                  <form method="post" action="import/ImportTsg" enctype="multipart/form-data">
                    <input type="file" name="file_upload">
                    <input type="submit" class="btn btn-success" name="submit" value="Import TSG">
                  </form>
                </div><!-- end col-->
              </div>
            </div> <!-- end card body -->
          </div> <!-- end card -->
        </div><!-- end col-->
    

    
        <div class="col-6">
          <div class="card">
            <div class="card-body">
              <div class="row mb-2">
                <div class="col-sm-12">
                  <form method="post" action="import/ImportJk" enctype="multipart/form-data">
                    <input type="file" name="file_upload">
                    <input type="submit" class="btn btn-success" name="submit" value="Import JK">
                  </form>
                </div><!-- end col-->
              </div>
            </div> <!-- end card body -->
          </div> <!-- end card -->
        </div><!-- end col-->
    


    
        <div class="col-6">
          <div class="card">
            <div class="card-body">
              <div class="row mb-2">
                <div class="col-sm-12">
                  <form method="post" action="import/ImportCnc" enctype="multipart/form-data">
                    <input type="file" name="file_upload">
                    <input type="submit" class="btn btn-success" name="submit" value="Import CNC">
                  </form>
                </div><!-- end col-->
              </div>
            </div> <!-- end card body -->
          </div> <!-- end card -->
        </div><!-- end col-->
      

      
        <div class="col-6">
          <div class="card">
            <div class="card-body">
              <div class="row mb-2">
                <div class="col-sm-12">
                  <form method="post" action="import/ImportWc" enctype="multipart/form-data">
                    <input type="file" name="file_upload">
                    <input type="submit" class="btn btn-success" name="submit" value="Import Wolf Classic">
                  </form>
                </div><!-- end col-->
              </div>
            </div> <!-- end card body -->
          </div> <!-- end card -->
        </div><!-- end col-->
      


      
        <div class="col-6">
          <div class="card">
            <div class="card-body">
              <div class="row mb-2">
                <div class="col-sm-12">
                  <form method="post" action="import/ImportTKnobs" enctype="multipart/form-data">
                    <input type="file" name="file_upload">
                    <input type="submit" class="btn btn-success" name="submit" value="Import Top Knobs">
                  </form>
                </div><!-- end col-->
              </div>
            </div> <!-- end card body -->
          </div> <!-- end card -->
        </div><!-- end col-->
      


      
        <div class="col-6">
          <div class="card">
            <div class="card-body">
              <div class="row mb-2">
                <div class="col-sm-12">
                  <form method="post" action="import/ImportAsfg" enctype="multipart/form-data">
                    <input type="file" name="file_upload">
                    <input type="submit" class="btn btn-success" name="submit" value="Import ASFG">
                  </form>
                </div><!-- end col-->
              </div>
            </div> <!-- end card body -->
          </div> <!-- end card -->
        </div><!-- end col-->

        <div class="col-6">
          <div class="card">
            <div class="card-body">
              <div class="row mb-2">
                <div class="col-sm-12">
                  <form method="post" action="import/ImportCentury" enctype="multipart/form-data">
                    <input type="file" name="file_upload">
                    <input type="submit" class="btn btn-success" name="submit" value="Import 21 Century">
                  </form>
                </div><!-- end col-->
              </div>
            </div> <!-- end card body -->
          </div> <!-- end card -->
        </div><!-- end col-->
       
        <div class="col-6">
          <div class="card">
            <div class="card-body">
              <div class="row mb-2">
                <div class="col-sm-12">
                  <form method="post" action="import/ImportAAY" enctype="multipart/form-data">
                    <input type="file" name="file_upload">
                    <input type="submit" class="btn btn-success" name="submit" value="Import AAY">
                  </form>
                </div><!-- end col-->
              </div>
            </div> <!-- end card body -->
          </div> <!-- end card -->
        </div><!-- end col-->
  </div>
</div> <!-- container -->