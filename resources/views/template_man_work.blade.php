@extends('layouts.app')
@push('styles')
<style>
/* .card-horizontal {
    display: flex;
    flex: 1 1 auto;
  } */

</style>
@endpush
@section('content')
    <div class="container-fluid" id="schedule_content">
        <div class="row">
            <div class="col">
                <div class="d-grid gap-2 d-md-block float-right">
                    <a class="btn btn-primary"  href="{{ url('/template_man_work_search')}}">查詢頁面<i class="fa fa-share" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
       
        <div class="row">
          <div class="input-group mb-3 mt-1" style="width: 500px;">
            <span class="input-group-text" id="inputGroup-sizing-default">人力配置樣板</span>
            <select class="form-control selectpicker" name="template_id" data-live-search="true" id="template_id"></select>
            <button class="btn btn-primary" onclick="btn_save()" type="button">儲存</button>
            {{-- <button class="btn btn-danger" onclick="btn_delete()" type="button">作廢</button> --}}
          </div>
          <div class="input-group mb-3 mt-1" style="width: 250px;">
            <span class="input-group-text" id="inputGroup-sizing-default">樣板名稱</span>
            <input type="text" class="form-control" aria-label="Sizing example input"  id="template_job_duty_name" aria-describedby="inputGroup-sizing-default">
          </div>
          <div class="input-group mb-3 mt-1" style="width: 250px;">
            <span class="input-group-text" id="inputGroup-sizing-default">樣板類型</span>
            <input type="text" class="form-control" aria-label="Sizing example input" readonly id="template_type" aria-describedby="inputGroup-sizing-default">
          </div>
        </div>
        <div id="week_container"></div>
{{-- 
        <div class="navbar" style="position: fixed;bottom: 0;width: 100%; background-color:gray; height:100px;">
          <a href="#home">Home</a>
          <a href="#news">News</a>
          <a href="#contact">Contact</a>
        </div> --}}
  </div>
    
@endsection
@section('scripts')
<script src="{{ asset('js/Sortable.js') }}" defer></script>
<script src="{{ asset('js/prettify.js') }}" defer></script>
<script src="{{ asset('js/run_prettify.js') }}" defer></script>
<script src="{{ asset('js/list_drag_app.js') }}" defer></script>
<script type="text/javascript">

        var final_solution=[];
        let result_json_array=[];

        function btn_delete(){
          $.ajax({
                type: 'POST',
                data:{
                    'id':$('#template_id').val()  
                },
                url: api_url + '/api/delete_template',
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: '註銷成功',
                        text: ''
                    });
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

        function btn_save(){
          if($('#template_job_duty_name').val()==''){
            Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: '樣板名稱必須填入'
                    });
                    return;
          }
    

          let get_array=JSON.parse(template_array[0].template_json) 
          for(let i=0;i<get_array.length;i++){
            let in_duty_morning_array=$(`input[name=in_duty_morning_${i}]:checked`).map(function(){return this.value;}).get();
            let out_duty_morning_array=$(`input[name=out_duty_morning_${i}]:checked`).map(function(){return this.value;}).get();
        
            let in_duty_noon_array=$(`input[name=in_duty_noon_${i}]:checked`).map(function(){return this.value;}).get();
            let out_duty_noon_array=$(`input[name=out_duty_noon_${i}]:checked`).map(function(){return this.value;}).get();
        
            let in_duty_night_array=$(`input[name=in_duty_night_${i}]:checked`).map(function(){return this.value;}).get();
            let out_duty_night_array=$(`input[name=out_duty_night_${i}]:checked`).map(function(){return this.value;}).get();
            get_array[i].want_morning_shift=in_duty_morning_array;
            get_array[i].want_noon_shift=in_duty_noon_array;
            get_array[i].want_night_shift=in_duty_night_array;
            get_array[i].dont_want_morning_shift=out_duty_morning_array;
            get_array[i].dont_want_noon_shift=out_duty_noon_array;
            get_array[i].dont_want_night_shift=out_duty_night_array;
          }
         

        $.ajax({
                type: 'POST',
                data:{
                    'template_id':$('#template_id').val(),
                    'template_job_duty_name':$('#template_job_duty_name').val(),
                    'template_json':JSON.stringify(get_array)
                },
                url: api_url + '/api/store_template_job_duty',
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: '更新成功',
                        text: ''
                    });
                    location.reload();
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

        function load_template(id){
            let get_select_template=template_array.filter(n=>n.id==id);
            let template_type=get_select_template[0].template_type;
            let template_json= JSON.parse(get_select_template[0].template_json) 
            $('#template_type').val((template_type==7)?'單週':'雙週');
            // $('#template_name').val($('#template_id option:selected') .text());
            let week_day='';
            $('#week_container').empty();   

            for(let i=0;i<template_json.length;i++){

              switch(template_json[i].week_day%7){
                case 1:
                  week_day='星期一';
                break;
                case 2:
                  week_day='星期二';
                break;
                case 3:
                  week_day='星期三';
                break;
                case 4:
                  week_day='星期四';
                break;
                case 5:
                  week_day='星期五';
                break;
                case 6:
                  week_day='星期六';
                break;
                case 0:
                  week_day='星期日';
                break;
              }
              // <input class="form-check-input me-1" id="full_time_doctor_morning_shift_${i}" type="checkbox" style="width: 30px;height:30px;" value="" aria-label="...">     
              $('#week_container').append(`
          
                    <div class="card mt-2">
                    <div class="card-horizontal">
                        <div class="card-header" >
                            <h4 class="align-self-center">${week_day}</h4> 
                        </div>
                        <div class="card-body">
                            <div class="row">
                              <div class="col-4">
                                <div class="row" id="duty_container_morning_${i}"></div>
                              </div>
                              <div class="col-4">
                                <div class="row" id="duty_container_noon_${i}"></div>
                              </div>
                              <div class="col-4">
                                <div class="row" id="duty_container_night_${i}"></div>
                              </div>
                            </div>
                        
                        
                        </div>
                    
                    </div>
                    <br>
                
                    `);
                    let induty_template_morning=employee_array.map(key => (
                        `

                        <input type="checkbox" id="in_duty_morning_${key.name}_${i}" name="in_duty_morning_${i}" value="${key.name}">
                        <label class="form-check-label" for="in_duty_morning_${key.name}_${i}">
                          ${key.name}
                        </label>
                        <br>`
                    )).join('');
    
                    let outduty_template_morning=employee_array.map(key => (
                        `<input type="checkbox" id="out_duty_morning_${key.name}_${i}" name="out_duty_morning_${i}" value="${key.name}">
                        <label class="form-check-label" for="out_duty_morning_${key.name}_${i}">
                          ${key.name}
                        </label>
                        <br>`
                    )).join('');

                    ////////////////

                    let induty_template_noon=employee_array.map(key => (
                        `

                        <input type="checkbox" id="in_duty_noon_${key.name}_${i}" name="in_duty_noon_${i}" value="${key.name}">
                        <label class="form-check-label" for="in_duty_noon_${key.name}_${i}">
                          ${key.name}
                        </label>
                        <br>`
                    )).join('');
                    let outduty_template_noon=employee_array.map(key => (
                        `<input type="checkbox" id="out_duty_noon_${key.name}_${i}" name="out_duty_noon_${i}" value="${key.name}">
                        <label class="form-check-label" for="out_duty_noon_${key.name}_${i}">
                          ${key.name}
                        </label>
                        <br>`
                    )).join('');

                    ///////////////
                    let induty_template_night=employee_array.map(key => (
                        `

                        <input type="checkbox" id="in_duty_night_${key.name}_${i}" name="in_duty_night_${i}" value="${key.name}">
                        <label class="form-check-label" for="in_duty_night_${key.name}_${i}">
                          ${key.name}
                        </label>
                        <br>`
                    )).join('');
                    let outduty_template_night=employee_array.map(key => (
                        `<input type="checkbox" id="out_duty_night_${key.name}_${i}" name="out_duty_night_${i}" value="${key.name}">
                        <label class="form-check-label" for="out_duty_night_${key.name}_${i}">
                          ${key.name}
                        </label>
                        <br>`
                    )).join('');

                    //////////////   

                        //   <div class="col-6 border-right"> 
                        //   <h6 class="text-center">排入<i class="fa fa-sun-o" aria-hidden="true"></i></h6>
                        //     ${induty_template_morning}
                        // </div>
                        // <div class="col-6 border-right"> 
                        //   <h6 class="text-center">不排入<i class="fa fa-sun-o" aria-hidden="true"></i></h6>
                        //     ${outduty_template_morning}   
                        // </div>   
                    $(`#duty_container_morning_${i}`).append(`
                        <div class="col-6 border-right"> 
                          <h6 class="text-center">排入<i class="fa fa-sun-o" aria-hidden="true"></i></h6>
                            ${induty_template_morning}
                        </div>
                        <div class="col-6 border-right"> 
                          <h6 class="text-center">不排入<i class="fa fa-sun-o" aria-hidden="true"></i></h6>
                            ${outduty_template_morning}   
                        </div>   
                    `);
                    $(`#duty_container_noon_${i}`).append(`
                        <div class="col-6 border-right"> 
                          <h6 class="text-center">排入<i class="fa fa-spoon" aria-hidden="true"></i></h6>
                            ${induty_template_noon}
                        </div>
                        <div class="col-6 border-right"> 
                          <h6 class="text-center">不排入<i class="fa fa-spoon" aria-hidden="true"></i></h6>
                            ${outduty_template_noon}   
                        </div>
                    `);
                    $(`#duty_container_night_${i}`).append(`
                        <div class="col-6 border-right"> 
                          <h6 class="text-center">排入<i class="fa fa-moon-o" aria-hidden="true"></i></h6>
                            ${induty_template_night}
                        </div>
                        <div class="col-6 border-right"> 
                          <h6 class="text-center">不排入<i class="fa fa-moon-o" aria-hidden="true"></i></h6>
                            ${outduty_template_night}   
                        </div>
                    `);

                }

                 
            }

        function load_employee(){
          
          $.ajax({
                type: 'POST',
                url: api_url + '/api/load_employee',
                success: function(data) {
                  employee_array=data;
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

        function load_template_api(){
          
          $.ajax({
                type: 'POST',
                url: api_url + '/api/load_template',
                success: function(data) {
                  template_array=data;
                  $('#template_id').append(`<option value="choose">請選擇樣板</option>`);
                          for(let i=0;i<data.length;i++){
                            $('#template_id').append(`<option value="${data[i].id}">${data[i].template_name}</option>`);
                          }
                          // $("#process_list").bsMultiSelect({cssPatch : {
                          //  choices: {columnCount:'1' },
                          // }});
                          $('#template_id').selectpicker('refresh');
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

        $( document ).ready(function() {
          let template_array;
          let employee_array;
            // load_template();
            load_employee();
            load_template_api();
            $('#template_id').on('change',function(){
                load_template($('#template_id').val());
            });


        });
</script>
@endsection

