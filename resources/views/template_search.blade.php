@extends('layouts.app')
@push('styles')
<style>
.card-horizontal {
    display: flex;
    flex: 1 1 auto;
  }
</style>
@endpush
@section('content')
    <div class="container-fluid" id="schedule_content">
        <div class="row">
            <div class="col">
                <div class="d-grid gap-2 d-md-block float-right">
                    <a class="btn btn-primary"  href="{{ url('/template')}}">新增頁面<i class="fa fa-share" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
       
        <div class="row">
          <div class="input-group mb-3 mt-1" style="width: 500px;">
            <span class="input-group-text" id="inputGroup-sizing-default">工作日樣板</span>
            <select class="form-control selectpicker" name="template_id" data-live-search="true" id="template_id"></select>
            <button class="btn btn-primary" onclick="btn_save()" type="button">儲存</button>
            <button class="btn btn-danger" onclick="btn_delete()" type="button">作廢</button>
          </div>
          <div class="input-group mb-3 mt-1" style="width: 250px;">
            <span class="input-group-text" id="inputGroup-sizing-default">樣板名稱</span>
            <input type="text" class="form-control" aria-label="Sizing example input"  id="template_name" aria-describedby="inputGroup-sizing-default">
          </div>
          <div class="input-group mb-3 mt-1" style="width: 250px;">
            <span class="input-group-text" id="inputGroup-sizing-default">樣板類型</span>
            <input type="text" class="form-control" aria-label="Sizing example input" readonly id="template_type" aria-describedby="inputGroup-sizing-default">
          </div>
        </div>
        <div id="week_container"></div>
  </div>
    
@endsection
@section('scripts')
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
   
    
          for(let i=0;i<=template_array[0].template_type;i++){
            let temp_array={};
            let temp_json={};
            temp_array.week_day=i+1;
 
            if($(`#full_time_doctor_morning_shift_human_resource_${i}`).val()!=""){
              temp_json.full_time_doctor_morning_shift=$(`#full_time_doctor_morning_shift_human_resource_${i}`).val();
            }else{
              temp_json.full_time_doctor_morning_shift=0;
            }
            if($(`#full_time_nurse_morning_shift_human_resource_${i}`).val()!=""){
              temp_json.full_time_nurse_morning_shift=$(`#full_time_nurse_morning_shift_human_resource_${i}`).val();
            }else{
              temp_json.full_time_nurse_morning_shift=0;
            }
            if($(`#full_time_pharmacist_morning_shift_human_resource_${i}`).val()!=""){
              temp_json.full_time_pharmacist_morning_shift=$(`#full_time_pharmacist_morning_shift_human_resource_${i}`).val();
            }else{
              temp_json.full_time_pharmacist_morning_shift=0;
            }
            if($(`#full_time_administration_staff_morning_shift_human_resource_${i}`).val()!=""){
              temp_json.full_time_administration_staff_morning_shift=$(`#full_time_administration_staff_morning_shift_human_resource_${i}`).val();
            }else{
              temp_json.full_time_administration_staff_morning_shift=0;
            }
            if($(`#part_time_worker_morning_shift_human_resource_${i}`).val()!=""){
              temp_json.part_time_worker_morning_shift=$(`#part_time_worker_morning_shift_human_resource_${i}`).val();
            }else{
              temp_json.part_time_worker_morning_shift=0;
            }

           
            if($(`#full_time_doctor_noon_shift_human_resource_${i}`).val()!=""){
              temp_json.full_time_doctor_noon_shift=$(`#full_time_doctor_noon_shift_human_resource_${i}`).val();
            }else{
              temp_json.full_time_doctor_noon_shift=0;
            }
            if($(`#full_time_nurse_noon_shift_human_resource_${i}`).val()!=""){
              temp_json.full_time_nurse_noon_shift=$(`#full_time_nurse_noon_shift_human_resource_${i}`).val();
            }else{
              temp_json.full_time_nurse_noon_shift=0;
            }
            if($(`#full_time_pharmacist_noon_shift_human_resource_${i}`).val()!=""){
              temp_json.full_time_pharmacist_noon_shift=$(`#full_time_pharmacist_noon_shift_human_resource_${i}`).val();
            }else{
              temp_json.full_time_pharmacist_noon_shift=0;
            }
            if($(`#full_time_administration_staff_noon_shift_human_resource_${i}`).val()!=""){
              temp_json.full_time_administration_staff_noon_shift=$(`#full_time_administration_staff_noon_shift_human_resource_${i}`).val();
            }else{
              temp_json.full_time_administration_staff_noon_shift=0;
            }
            if($(`#part_time_worker_noon_shift_human_resource_${i}`).val()!=""){
              temp_json.part_time_worker_noon_shift=$(`#part_time_worker_noon_shift_human_resource_${i}`).val();
            }else{
              temp_json.part_time_worker_noon_shift=0;
            }

          
            if($(`#full_time_doctor_night_shift_human_resource_${i}`).val()!=""){
              temp_json.full_time_doctor_night_shift=$(`#full_time_doctor_night_shift_human_resource_${i}`).val();
            }else{
              temp_json.full_time_doctor_night_shift=0;
            }
            if($(`#full_time_nurse_night_shift_human_resource_${i}`).val()!=""){
              temp_json.full_time_nurse_night_shift=$(`#full_time_nurse_night_shift_human_resource_${i}`).val();
            }else{
              temp_json.full_time_nurse_night_shift=0;
            }
            if($(`#full_time_pharmacist_night_shift_human_resource_${i}`).val()!=""){
              temp_json.full_time_pharmacist_night_shift=$(`#full_time_pharmacist_night_shift_human_resource_${i}`).val();
            }else{
              temp_json.full_time_pharmacist_night_shift=0;
            }
            if($(`#full_time_administration_staff_night_shift_human_resource_${i}`).val()!=""){
              temp_json.full_time_administration_staff_night_shift=$(`#full_time_administration_staff_night_shift_human_resource_${i}`).val();
            }else{
              temp_json.full_time_administration_staff_night_shift=0;
            }
            if($(`#part_time_worker_night_shift_human_resource_${i}`).val()!=""){
              temp_json.part_time_worker_night_shift=$(`#part_time_worker_night_shift_human_resource_${i}`).val();
            }else{
              temp_json.part_time_worker_night_shift=0;
            }
            temp_array.job_require=temp_json;
            result_json_array.push(temp_array);
          }


        //   
        $.ajax({
                type: 'POST',
                data:{
                    'id':$('#template_id').val(),
                    'template_name':$('#template_name').val(),
                    'template_json':JSON.stringify(result_json_array)
                },
                url: api_url + '/api/update_template',
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: '更新成功',
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

        function load_template(id){
            let get_select_template=template_array.filter(n=>n.id==id);
            let template_type=get_select_template[0].template_type;
            let template_json= JSON.parse(get_select_template[0].template_json) 
            $('#template_type').val((template_type==7)?'單週':'雙週');
            $('#template_name').val($('#template_id option:selected') .text());
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
                                <h5 class="text-center">早班</h5>
                                    <div class="input-group mb-2">
                                      <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">醫師</span>
                                      </div>
                                      <input type="number" class="form-control input-append" id="full_time_doctor_morning_shift_human_resource_${i}" placeholder="填入所需人力" min='1' value="${template_json[i].job_require.full_time_doctor_morning_shift}">
                                    </div>
                                      <div class="input-group mb-2">
                                    
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" id="basic-addon1">藥劑師</span>
                                        </div>
                                        <input type="number" class="form-control input-append" id="full_time_pharmacist_morning_shift_human_resource_${i}" placeholder="填入所需人力" min='1' value="${template_json[i].job_require.full_time_pharmacist_morning_shift}">
                                      </div>
                                      <div class="input-group mb-2">
                                    
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" id="basic-addon1">護士</span>
                                        </div>
                                        <input type="number" class="form-control input-append" id="full_time_nurse_morning_shift_human_resource_${i}" placeholder="填入所需人力" min='1' value="${template_json[i].job_require.full_time_nurse_morning_shift}">
                                      </div>
                                      <div class="input-group mb-2">
                                    
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" id="basic-addon1">行政人員</span>
                                        </div>
                                        <input type="number" class="form-control input-append" id="full_time_administration_staff_morning_shift_human_resource_${i}"  placeholder="填入所需人力" min='1' value="${template_json[i].job_require.full_time_administration_staff_morning_shift}">
                                      </div>
                                      <div class="input-group mb-2">
                                    
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" id="basic-addon1">工讀生</span>
                                        </div>
                                        <input type="number" class="form-control input-append" id="part_time_worker_morning_shift_human_resource_${i}" placeholder="填入所需人力" min='1' value="${template_json[i].job_require.part_time_worker_morning_shift}">
                                      </div>
                              </div>
                              <div class="col-4">
                                <h5 class="text-center">中班</h5>
                                    <div class="input-group mb-2">
                                      <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">醫師</span>
                                      </div>
                                      <input type="number" class="form-control input-append" id="full_time_doctor_noon_shift_human_resource_${i}" placeholder="填入所需人力" min='1' value="${template_json[i].job_require.full_time_doctor_noon_shift}">
                                    </div>
                                      <div class="input-group mb-2">
                                    
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" id="basic-addon1">藥劑師</span>
                                        </div>
                                        <input type="number" class="form-control input-append" id="full_time_pharmacist_noon_shift_human_resource_${i}" placeholder="填入所需人力" min='1' value="${template_json[i].job_require.full_time_pharmacist_noon_shift}">
                                      </div>
                                      <div class="input-group mb-2">
                                    
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" id="basic-addon1">護士</span>
                                        </div>
                                        <input type="number" class="form-control input-append" id="full_time_nurse_noon_shift_human_resource_${i}" placeholder="填入所需人力" min='1' value="${template_json[i].job_require.full_time_nurse_noon_shift}">
                                      </div>
                                      <div class="input-group mb-2">
                                    
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" id="basic-addon1">行政人員</span>
                                        </div>
                                        <input type="number" class="form-control input-append" id="full_time_administration_staff_noon_shift_human_resource_${i}"  placeholder="填入所需人力" min='1' value="${template_json[i].job_require.full_time_administration_staff_noon_shift}">
                                      </div>
                                      <div class="input-group mb-2">
                                    
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" id="basic-addon1">工讀生</span>
                                        </div>
                                        <input type="number" class="form-control input-append" id="part_time_worker_noon_shift_human_resource_${i}" placeholder="填入所需人力" min='1' value="${template_json[i].job_require.part_time_worker_noon_shift}">
                                      </div>
                              </div>
                              <div class="col-4">
                                <h5 class="text-center">晚班</h5>
                                <div class="input-group mb-2">
                                      <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">醫師</span>
                                      </div>
                                      <input type="number" class="form-control input-append" id="full_time_doctor_night_shift_human_resource_${i}" placeholder="填入所需人力" min='1' value="${template_json[i].job_require.full_time_doctor_night_shift}">
                                    </div>
                                      <div class="input-group mb-2">
                                    
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" id="basic-addon1">藥劑師</span>
                                        </div>
                                        <input type="number" class="form-control input-append" id="full_time_pharmacist_night_shift_human_resource_${i}" placeholder="填入所需人力" min='1' value="${template_json[i].job_require.full_time_pharmacist_night_shift}">
                                      </div>
                                      <div class="input-group mb-2">
                                    
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" id="basic-addon1">護士</span>
                                        </div>
                                        <input type="number" class="form-control input-append" id="full_time_nurse_night_shift_human_resource_${i}" placeholder="填入所需人力" min='1' value="${template_json[i].job_require.full_time_nurse_night_shift}">
                                      </div>
                                      <div class="input-group mb-2">
                                    
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" id="basic-addon1">行政人員</span>
                                        </div>
                                        <input type="number" class="form-control input-append" id="full_time_administration_staff_night_shift_human_resource_${i}"  placeholder="填入所需人力" min='1' value="${template_json[i].job_require.full_time_administration_staff_night_shift}">
                                      </div>
                                      <div class="input-group mb-2">
                                    
                                        <div class="input-group-prepend">
                                          <span class="input-group-text" id="basic-addon1">工讀生</span>
                                        </div>
                                        <input type="number" class="form-control input-append" id="part_time_worker_night_shift_human_resource_${i}" placeholder="填入所需人力" min='1' value="${template_json[i].job_require.part_time_worker_night_shift}">
                                      </div>
                              </div>
                            </div>
                        </div>
                    </div>
                    </div>  
                    <br>
                
                    `);
                
                    }

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
            // load_template();
            load_template_api();
            $('#template_id').on('change',function(){
                load_template($('#template_id').val());
            });


        });
</script>
@endsection

