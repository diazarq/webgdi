<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="{{ asset('admin/assets/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet"/>
    <link href="{{ asset('admin/assets/plugins/metismenu/metisMenu.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('admin/assets/plugins/scss/custom.css') }}" rel="stylesheet"/>

    <title>{{ $title ?? 'CMS' }}</title>
  </head>
  <body>
    <header class="cs-header">
      <div class="cs-toggle" data-open="false" ><i class="bi-list"></i></div>
      <div class="cs-title">CMS</div>
    </header>

    <div class="cs-left-bar" id="slide">
      <nav>
        <ul class="metismenu">
          <li><a href="#" class="active"><i class="cs-menu-icon bi-house"></i> Beranda</a></li>
          <li><a href="#"><i class="cs-menu-icon bi-grid"></i> Stock Opname</a></li>
          <li><a href="#" class="cs-menu-dropdown has-arrow active" aria-expanded="true"><i class="cs-menu-icon bi-wrench-adjustable-circle"></i> Pengaturan</a>
            <ul class="cs-menu-dropdown-item mm-collapse mm-show">
              <li><a href="#" class="active">Pengaturan Umum</a></li>
              <li><a href="#">Pengguna</a></li>
            </ul>
          </li>
          <li><a href="#" class="cs-menu-dropdown has-arrow"><i class="cs-menu-icon bi-wrench-adjustable-circle"></i> Pengaturan</a>
            <ul class="cs-menu-dropdown-item">
              <li><a href="#">Pengaturan Umum</a></li>
              <li><a href="#">Pengguna</a></li>
            </ul>
          </li>
        </ul>
      </nav>
    </div>

    <div class="cs-right-content">
      <div class="container">
        <!-- breadcrumbs -->
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="bi-house"></i></a></li>
            <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pengguna</li>
          </ol>
        </nav>

        <div class="cs-segment">
          <div class="container">
            <h5>Page Title</h5>
            <div class="row">
              <div class="col-6">
                <form>
                  <div class="mb-3 row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                      <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="email@example.com">
                    </div>
                  </div>
                  <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-6">
                      <input type="password" class="form-control form-control" readonly id="inputPassword" value="Sampe">
                    </div>
                  </div>
                  <div class="mb-3 row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Sample</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control form-control" id="inputPassword" placeholder="Sample">
                    </div>
                  </div>
                  <div class="mb-3 row">
                    <label class="col-sm-2">&nbsp;</label>
                    <div class="col-sm-10">
                      <button type="button" class="btn btn-primary"><i class="bi-save"></i> Submit</button>
                      <button type="button" class="btn btn-primary btn-alert">Modal Alert Sample</button>
                      <button type="button" class="btn btn-primary" id="liveToastBtn">Show live toast</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <hr>

            <table id="example" class="table" style="width:100%">
              <thead>
                  <tr>
                      <th>Name</th>
                      <th>Position</th>
                      <th>Office</th>
                      <th>Age</th>
                      <th>Start date</th>
                      <th>Salary</th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <td>Tiger Nixon</td>
                      <td>System Architect</td>
                      <td>Edinburgh</td>
                      <td>61</td>
                      <td>2011-04-25</td>
                      <td>$320,800</td>
                  </tr>
                  <tr>
                      <td>Garrett Winters</td>
                      <td>Accountant</td>
                      <td>Tokyo</td>
                      <td>63</td>
                      <td>2011-07-25</td>
                      <td>$170,750</td>
                  </tr>
                  <tr>
                      <td>Ashton Cox</td>
                      <td>Junior Technical Author</td>
                      <td>San Francisco</td>
                      <td>66</td>
                      <td>2009-01-12</td>
                      <td>$86,000</td>
                  </tr>
                  <tr>
                      <td>Cedric Kelly</td>
                      <td>Senior Javascript Developer</td>
                      <td>Edinburgh</td>
                      <td>22</td>
                      <td>2012-03-29</td>
                      <td>$433,060</td>
                  </tr>
                  <tr>
                      <td>Airi Satou</td>
                      <td>Accountant</td>
                      <td>Tokyo</td>
                      <td>33</td>
                      <td>2008-11-28</td>
                      <td>$162,700</td>
                  </tr>
                  <tr>
                      <td>Brielle Williamson</td>
                      <td>Integration Specialist</td>
                      <td>New York</td>
                      <td>61</td>
                      <td>2012-12-02</td>
                      <td>$372,000</td>
                  </tr>
                  <tr>
                      <td>Herrod Chandler</td>
                      <td>Sales Assistant</td>
                      <td>San Francisco</td>
                      <td>59</td>
                      <td>2012-08-06</td>
                      <td>$137,500</td>
                  </tr>
                  <tr>
                      <td>Rhona Davidson</td>
                      <td>Integration Specialist</td>
                      <td>Tokyo</td>
                      <td>55</td>
                      <td>2010-10-14</td>
                      <td>$327,900</td>
                  </tr>
                  <tr>
                      <td>Colleen Hurst</td>
                      <td>Javascript Developer</td>
                      <td>San Francisco</td>
                      <td>39</td>
                      <td>2009-09-15</td>
                      <td>$205,500</td>
                  </tr>
                  <tr>
                      <td>Sonya Frost</td>
                      <td>Software Engineer</td>
                      <td>Edinburgh</td>
                      <td>23</td>
                      <td>2008-12-13</td>
                      <td>$103,600</td>
                  </tr>
                  <tr>
                      <td>Jena Gaines</td>
                      <td>Office Manager</td>
                      <td>London</td>
                      <td>30</td>
                      <td>2008-12-19</td>
                      <td>$90,560</td>
                  </tr>
                  <tr>
                      <td>Quinn Flynn</td>
                      <td>Support Lead</td>
                      <td>Edinburgh</td>
                      <td>22</td>
                      <td>2013-03-03</td>
                      <td>$342,000</td>
                  </tr>
                  <tr>
                      <td>Charde Marshall</td>
                      <td>Regional Director</td>
                      <td>San Francisco</td>
                      <td>36</td>
                      <td>2008-10-16</td>
                      <td>$470,600</td>
                  </tr>
                  <tr>
                      <td>Haley Kennedy</td>
                      <td>Senior Marketing Designer</td>
                      <td>London</td>
                      <td>43</td>
                      <td>2012-12-18</td>
                      <td>$313,500</td>
                  </tr>
                  <tr>
                      <td>Tatyana Fitzpatrick</td>
                      <td>Regional Director</td>
                      <td>London</td>
                      <td>19</td>
                      <td>2010-03-17</td>
                      <td>$385,750</td>
                  </tr>
                  <tr>
                      <td>Michael Silva</td>
                      <td>Marketing Designer</td>
                      <td>London</td>
                      <td>66</td>
                      <td>2012-11-27</td>
                      <td>$198,500</td>
                  </tr>
                  <tr>
                      <td>Paul Byrd</td>
                      <td>Chief Financial Officer (CFO)</td>
                      <td>New York</td>
                      <td>64</td>
                      <td>2010-06-09</td>
                      <td>$725,000</td>
                  </tr>
                  <tr>
                      <td>Gloria Little</td>
                      <td>Systems Administrator</td>
                      <td>New York</td>
                      <td>59</td>
                      <td>2009-04-10</td>
                      <td>$237,500</td>
                  </tr>
                  <tr>
                      <td>Bradley Greer</td>
                      <td>Software Engineer</td>
                      <td>London</td>
                      <td>41</td>
                      <td>2012-10-13</td>
                      <td>$132,000</td>
                  </tr>
                  <tr>
                      <td>Dai Rios</td>
                      <td>Personnel Lead</td>
                      <td>Edinburgh</td>
                      <td>35</td>
                      <td>2012-09-26</td>
                      <td>$217,500</td>
                  </tr>
                  <tr>
                      <td>Jenette Caldwell</td>
                      <td>Development Lead</td>
                      <td>New York</td>
                      <td>30</td>
                      <td>2011-09-03</td>
                      <td>$345,000</td>
                  </tr>
                  <tr>
                      <td>Yuri Berry</td>
                      <td>Chief Marketing Officer (CMO)</td>
                      <td>New York</td>
                      <td>40</td>
                      <td>2009-06-25</td>
                      <td>$675,000</td>
                  </tr>
                  <tr>
                      <td>Caesar Vance</td>
                      <td>Pre-Sales Support</td>
                      <td>New York</td>
                      <td>21</td>
                      <td>2011-12-12</td>
                      <td>$106,450</td>
                  </tr>
                  <tr>
                      <td>Doris Wilder</td>
                      <td>Sales Assistant</td>
                      <td>Sydney</td>
                      <td>23</td>
                      <td>2010-09-20</td>
                      <td>$85,600</td>
                  </tr>
                  <tr>
                      <td>Angelica Ramos</td>
                      <td>Chief Executive Officer (CEO)</td>
                      <td>London</td>
                      <td>47</td>
                      <td>2009-10-09</td>
                      <td>$1,200,000</td>
                  </tr>
                </tbody>
            </table>
          </div>
          
        </div>
      </div>
      
    </div>

    <!-- toastr -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
      <div id="liveToast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
          <div class="toast-body">
            <strong>Error!</strong> Data gagal dihapus!
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>
    </div>

    <script src="{{ asset('admin/assets/plugins/jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- datatable -->
    <script src="{{ asset('admin/assets/plugins/datatable/datatables.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/metismenu/metismenu.js') }}"></script>
    <script src="{{ asset('admin/assets/js/main.js') }}"></script>
    
    

    <script>
      $(document).ready(function(){
        $('#example').DataTable({
          responsive: true
        });
        $(".metismenu").metisMenu();
        

        function toggle () {
          document.getElementById("slide").classList.toggle("hide");
        } 
        $('.cs-toggle').click(function(){
          var stat = $(this).attr('data-open');
          
          if(stat == 'true'){
            $(this).attr('data-open', false);
            $(this).empty().append('<i class="bi-list"></i>');
          }else{
            $(this).attr('data-open', true);
            $(this).empty().append('<i class="bi-x-lg"></i>');
          }
          toggle();
        });

        /* modal alert: nanti jadi plugins sendiri */
        function bpModalAlert(data){

          $('body').append('<div class="modal fade" id="dynamic-alert" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">'+
              '<div class="modal-dialog modal-dialog-centered">'+
                '<div class="modal-content">'+
                  '<div class="modal-header">'+
                    '<h5 class="modal-title" id="staticBackdropLabel">'+data.title+'</h5>'+
                    '<button type="button" class="btn-close dynamic-alert-close" data-bs-dismiss="modal" aria-label="Close"></button>'+
                  '</div>'+
                  '<div class="modal-body">'+data.message+'</div>'+
                  '<div class="modal-footer">'+
                    '<button type="button" class="btn btn-secondary dynamic-alert-close" data-bs-dismiss="modal">Batal</button>'+
                    '<button type="button" class="btn btn-primary dynamic-alert-action" data-bs-dismiss="modal">'+data.buttonText+'</button>'+
                  '</div>'+
                '</div>'+
              '</div>'+
            '</div>');

            $('#dynamic-alert').modal('show');

            function removeModal(){
              $('#dynamic-alert').fadeOut(200, function(){
                $(this).remove();
              });
            }
            
            var newFunction = data.onSuccess;
            $(document).on('click', '.dynamic-alert-action', function(e){
              e.preventDefault();
              newFunction();
              removeModal();
            })

            $(document).on('click', '.dynamic-alert-close', function(){
              removeModal();
            });

        }

        $('.btn-alert').click(function(){
          bpModalAlert({
            title: 'Peringatan!',
            message: 'Data akan dihapus secara permanen!',
            type: 'danger',
            buttonText: 'Hapus',
            onSuccess: function(){
              bpToast('success', 'data berhasil dihapus');
            }
          });
        })
        

        /* toast */
        function bpToast(types, message){
          switch(types){
            case 'success':
              var type = 'bg-success';
              break;
            case 'danger':
              var type = 'bg-danger';
              break;
            case 'warning':
              var type = 'bg-warning';
              break;
            default:
              var type = 'bg-primary';
              break;
          }

          var findContainer = $('body').find('.toast-container').length;
          if(findContainer == 0){
            $('body').append('<div class="toast-container"><div>');
            $('<div class="position-fixed top-0 end-0 p-3" style="z-index: 11">'+
              '<div id="dynamic-toast" class="toast align-items-center text-white '+type+' border-0" role="alert" aria-live="assertive" aria-atomic="true">'+
                '<div class="d-flex">'+
                  '<div class="toast-body">'+message+'</div>'+
                  '<button type="button" class="btn-close btn-close-white me-2 m-auto dynamic-toast" data-bs-dismiss="toast" aria-label="Close"></button>'+
                '</div>'+
              '</div>'+
            '</div>').appendTo('.toast-container');
          }else{
            $('<div class="position-fixed top-0 end-0 p-3" style="z-index: 11">'+
              '<div id="dynamic-toast" class="toast align-items-center text-white '+type+' border-0" role="alert" aria-live="assertive" aria-atomic="true">'+
                '<div class="d-flex">'+
                  '<div class="toast-body">'+message+'</div>'+
                  '<button type="button" class="btn-close btn-close-white me-2 m-auto dynamic-toast" data-bs-dismiss="toast" aria-label="Close"></button>'+
                '</div>'+
              '</div>'+
            '</div>').appendTo('.toast-container');
          }
          
          

          var toastLiveExample = document.getElementById('dynamic-toast')
          var toast = new bootstrap.Toast(toastLiveExample)
          toast.show();

          $(document).on('click', '.dynamic-toast', function(){
            $('#dynamic-toast').parent().remove();
          })
        }

        //bpToast('success', 'data berhasil dihapus');
        
        
      });
    </script>

    <!-- Iconify Web Component Global -->
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
  </body>
</html>