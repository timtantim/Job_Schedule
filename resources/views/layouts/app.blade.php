<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

   
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    {{-- <script src="{{ asset('js/jquery.min.js') }}"></script> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('js/popper.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/global.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        /* width */
        ::-webkit-scrollbar {
          width: 10px;
        }
        
        /* Track */
        ::-webkit-scrollbar-track {
          background: #f1f1f1; 
        }
         
        /* Handle */
        ::-webkit-scrollbar-thumb {
          background: #888; 
        }
        
        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
          background: #555; 
        }
        .nounderline {
          text-decoration: none !important
        }
        </style>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    @stack('styles')
</head>
<body>


    <div class="wrapper d-flex align-items-stretch">
        <nav id="sidebar">
            <div class="custom-menu">
                <button type="button" id="sidebarCollapse" class="btn btn-primary">
                    <i class="fa fa-bars"></i>
                    <span class="sr-only">Toggle Menu</span>
                </button>
            </div>
            <div class="p-4">
                      <h1><a href="index.html" class="logo nounderline">工作排班 <span>Portfolio Agency</span></a></h1>
                <ul class="list-unstyled components mb-5">
                  <li class="active">
                    <a class="nounderline" href="{{ url('/template')}}" style="font-size: 20px;"><span class="fa fa-home mr-3"></span>人力配置樣板</a>
                  </li>
                  <li class="active">
                      <a class="nounderline" href="{{ url('/template_man_work')}}"style="font-size: 20px;"><span class="fa fa-user mr-3"></span> 人員預排樣板</a>
                  </li>
                  <li class="active">
                  <a class="nounderline" href="{{ url('/template_create_time_table')}}"style="font-size: 20px;"><span class="fa fa-briefcase mr-3"></span>建立工作班</a>
                  </li>
                  <li class="active">
                  <a class="nounderline" href="#"style="font-size: 20px;"><span class="fa fa-sticky-note mr-3"></span>工作班休假預排</a>
                  </li>
                  <li class="active">
                  <a class="nounderline" href="#"style="font-size: 20px;"><span class="fa fa-suitcase mr-3"></span> 工作班排程</a>
                  </li>
                </ul>
            
                <div class="mb-5">
                            <h3 class="h6 mb-3">Subscribe for newsletter</h3>
                            <form action="#" class="subscribe-form">
                    <div class="form-group d-flex">
                        <div class="icon"><span class="icon-paper-plane"></span></div>
                      <input type="text" class="form-control" placeholder="Enter Email Address">
                    </div>
                  </form>
                        </div>
                    
                <div class="footer">
                    <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                              Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib.com</a>
                              <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                </div>
            
            </div>
        </nav>

        <!-- Page Content  -->
        {{-- <div id="content" class="p-4 p-md-5 pt-5"> --}}
        <div id="content" class=" p-md-3 ">
            @yield('content')
        </div>
    </div>




















{{-- 

    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm" style="background-color: #138095;">
            <a class="navbar-brand" href="{{ url('/') }}"  style="color: white; float:left;">

                v1.0-2021/05/05
            </a>
            <div class="container">
     
        
                <div class="collapse navbar-collapse" id="navbarSupportedContent"></div>
                    <div class="navbar-collapse collapse">
                        <ul class="nav navbar-nav navbar-center">
                            <li><span style="color: white;font-size:18px;">{{$title}}</span></li>
                        </ul>
                    </div>
    
        
                    <ul class="nav navbar-nav navbar-right">
        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" style="color: white;" href="#" id="login_user_name" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
                            <div class="dropdown-menu" aria-labelledby="login_user_name">
                              <a class="dropdown-item" href="#" onclick="logoff();return false;">登出</a>

                            </div>
                          </li>
                    </ul>
                    
            </div>
        </nav>
        <main>
            <div class="container-fluid" style="padding-left: 0px;padding-right: 0px;">   
                <div class="wrapper">
                    <!-- Sidebar  -->
                    <nav id="sidebar">
                        <ul class="list-unstyled components">

                            <li class="active basic_role"  >
                             
                                <a href="#customBasicInfoSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle menu-sidebar" style="font-size:25px;">   <i class="fa fa-cube" aria-hidden="true"></i> 基本檔維護</a>
                                <ul class="collapse list-unstyled" id="customBasicInfoSubmenu">
                                    <li style="font-size:20px;"> 
                                        <a href="{{ url('/company_info_search')}}" >客戶基本資料</a>
                                        <a class="human_role" href="{{ url('/human_resource_search')}}" style="font-size:25px;">人員管理</a>
                                
                                    </li>
                                </ul>
                            </li>    
                        </ul>
            
                      
                    </nav>
            

                    <div id="content" style="padding-left: 0px; padding-right:0px;padding-top:0px;padding-bottom:0px;">
            
                        <nav class="navbar navbar-expand-lg navbar-light bg-light">
                            <div class="container-fluid">
            
                                <button type="button" id="sidebarCollapse" class="btn btn-info">
                                    <i class="fas fa-align-left"></i>

                                </button>

                            </div>
                        </nav>
                    
                        @yield('content')
                    </div>

                       
                    <div class="modal modal-xl fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="padding: 0 !important;">
                      <div class="modal-dialog" role="document" style="width: 100%;max-width: none;height: 100%;margin: 0;">
                        <div class="modal-content" style="height: 100%;border: 0;border-radius: 0;">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">使用頻率</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body" style="overflow-y: auto;">
                            <div id="barchart-container" style="width: 100%;height: 100%;margin: 0;padding: 0;"></div>
                          </div>
                        </div>
                      </div>
                    </div>
             
                </div>
            </div>
 
            <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-keyboard="false" data-backdrop="static">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content" style="padding: 1rem;">
                    <div class="modal-header border-bottom-0">
                    </div>
                    <div class="modal-body">
                      <div class="form-title text-center">
                        <h4 style="font-weight: bold;">員工登入</h4>
                      </div>
                      <div class="d-flex flex-column text-center mt-4">
                        <form>
                          <div class="form-group">
                            <input type="text" class="form-control" id="login_user_id"  placeholder="您的員工編號...">
                          </div>
                          <div class="form-group">
                            <input type="password" class="form-control" id="login_user_password" placeholder="密碼...">
                          </div>
                          <button type="button" id="account_login_btn" class="btn btn-info btn-block" style="border-radius: 3rem; color:white;">登入</button>
                        </form>
                        
                      </div>
                    </div>
                </div>
              </div>

          
        </main>
       
    </div> --}}
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
    <script type="text/javascript">
        function logoff(){
            sessionStorage.removeItem('user_id');
            sessionStorage.removeItem('user_name');
            sessionStorage.removeItem('role');
            // location.reload();
            window.location.href ='/';
        }
        function check_user_role(){
            $.ajax({
                type: 'POST',
                data:{'user_id':sessionStorage.getItem("user_id")},
                url: api_url + '/api/check_user_role',
                success: function(data) {
                    let all_page=data.all_page;
                    let page=data.page;
                    for(let i=0;i<all_page.length;i++){
                        $(`.${all_page[i].html_class_name}`).css('display','none');
                    }
                    for(let i=0;i<page.length;i++){
                        $(`.${page[i].html_class_name}`).css('display','');
                    }
                },
                error: function(xhr, status, error) {
                    let err = xhr.responseText;
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: err
                    });
                }
            });
        }
        $(document).ready(function () {
            var get_user_id = sessionStorage.getItem("user_id");
            var get_user_name = sessionStorage.getItem("user_name");
            var get_user_role= sessionStorage.getItem("role");

            // check_user_role();
 
            $('#login_user_name').text('您好! '+get_user_name);
            if(get_user_id==null){
                $('#loginModal').modal('show');
            }

            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });

            // 
            $('#account_login_btn').on('click', function () {
                let user_id=$('#login_user_id').val();
                let password=$('#login_user_password').val();
                $.ajax({
                type: 'POST',
                data:{'user_id':user_id,'password':password},
                url: api_url + '/api/custom_login',
                success: function(data) {
                    let all_page=data.all_page;
                    let page=data.page;
                    data=data.account;
                    sessionStorage.setItem("user_id",user_id );
                    sessionStorage.setItem("user_name",data[0].name );
                    sessionStorage.setItem("role",data[0].role );


                    // sessionStorage.setItem("mes_role",'0' );
                    // sessionStorage.setItem("sale_role",'0' );
                    // sessionStorage.setItem("storage_role",'0' );
                    // sessionStorage.setItem("basic_role",'0' );
                    // sessionStorage.setItem("deliver_role",'0' );
                    // for(let i=0;i<all_page.length;i++){
                    //     sessionStorage.setItem(`${all_page[i].html_class_name}`,'0');       
                    // }
                    // for(let i=0;i<page.length;i++){
                    //     sessionStorage.setItem(`${page[i].html_class_name}`,'1');
                        
                    // }
                    // sessionStorage.setItem("mes_role",data[0].mes_role );
                    // sessionStorage.setItem("sale_role",data[0].sale_role );
                    // sessionStorage.setItem("storage_role",data[0].storage_role );
                    // sessionStorage.setItem("basic_role",data[0].basic_role );
                    // sessionStorage.setItem("deliver_role",data[0].deliver_role );
                 

                    $('#loginModal').modal('hide');
                    $('#login_user_name').text('您好! '+data);
                    location.reload();
                },
                error: function(xhr, status, error) {
                    let err = JSON.parse(xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: '登入失敗'
                    });
                }
            });
            });
        });
    </script>
    @yield ('scripts')
</body>
</html>
