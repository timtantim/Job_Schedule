  
/**
 * @name 渲染查詢頁面
 * @summary
 * 實現可輸入式快速導航特定頁面輸入框
 * @example
 *
 */

class RenderPage {
   
    constructor(container_id,table_head,table_detail) {
        // Container Dom ID
        this.container_id = container_id;
        // Table Head 資料
        this.table_head = table_head;
        // Table Detail 資料
        this.table_detail=table_detail;
     

        // 初始化
        this._init();
    }
    // 選染html
    _render_template() {
        $(`#${this.container_id}`).append(`
        <div class="row mt-5 px-3">
        <div class="table-responsive">
              <table class="table table-bordered" id="${this.table_head.table_head_id}"><thead class="table-primary"><tr></tr></thead><tbody></tbody></table>          
          </div> 
        </div>
        `);
    }
    // 渲染Table head 值
    _render_header() {
        (this.table_detail!=null)?$(`#${this.table_head.table_head_id} thead tr`).append(`<th>${this.table_detail.detail_row_name}</th>`):'';
        for(let i=0;i<this.table_head.table_head_culumn.length;i++){
            $(`#${this.table_head.table_head_id} thead tr`).append(`<th>${this.table_head.table_head_culumn[i].column_name}</th>`);
        }
        $(`#${this.table_head.table_head_id} thead tr`).append(`<th>編輯</th>`);
    }
    // 渲染Table head 值
    _render_head_body() {
        $.ajax({
            type: 'POST',
            url: api_url + `/api/${this.table_head.api_name}`,
            success: function(column_array,detail_name,data) {
              
              for(let i=0;i<data.length;i++){
                  let td_temp='';
                  (detail_name!=null)?td_temp+=`<td><button type="button" class="btn btn-info row-detail" style="color:white;">${detail_name.detail_row_name}</button></td>`:'';
                  for(let a=0;a<column_array.table_head_culumn.length;a++){
                    td_temp+=`
                    <td id="${column_array.table_head_culumn[a].column_id}_${data[i].id}">${(column_array.table_head_culumn[a].column_id=='status')?
                        (data[i][column_array.table_head_culumn[a].column_id]=='Y')?'已作廢':'尚未作廢':
                        (data[i][column_array.table_head_culumn[a].column_id]==null)?'':data[i][column_array.table_head_culumn[a].column_id]}</td>`;
                   
                  }
                  if(column_array.edit_button.length!=0){
                    td_temp+=`<td>`;
                    for(let a=0;a<column_array.edit_button.length;a++){
                        td_temp+=`
                            <button type="button" class="${column_array.edit_button[a].class}" style="${column_array.edit_button[a].style}" onclick="${column_array.edit_button[a].onclick}('${data[i][column_array.edit_button[a].parameter_column_name]}');">${column_array.edit_button[a].button_name}</button>
                        `;
                      }
                      td_temp+=`
                        <button type="button" id="btn_status_${data[i].id}" class="btn btn-md ${(data[i].status=='N')?'btn-danger':'btn-success'}" style="color:white;" onclick="update_status('${data[i].id}');">${(data[i].status=='N')?'作廢':'復原'}</button>
                      `
                      td_temp+=`</td>`;
                  }
                
                  $('#table-list-head').find('tbody').append(`<tr>${td_temp}</tr>`);
                  if(detail_name!=false){

                      $('#table-list-head').find('tbody').append(`
                      <tr id="${data[i][detail_name.detail_row_id]}"><td colspan="16" style="padding-bottom:0px;padding-top:0px;"><div></div></td></tr>
                      `);
                  }
              }
              $(`td[colspan=${column_array.table_head_culumn.length}]`).find("div").hide();
              $(".row-detail").click(function(event) {
                  event.stopPropagation();
                  var $target = $(event.target);
                  if ( $target.closest("tr").next().find("div").find("table").length>0) {
                      $target.closest("tr").next().find("div").slideToggle();
                  } else {
              
                      $('#table-list-head tr div').slideUp();
                      $('#table-list-head tr div').empty();
                      let row_id= $target.closest("tr").next()[0].id;
                      $target.closest("tr").next().find("div").empty();
                      let obj={};
                      obj[detail_name.detail_row_id]=row_id;
                      $.ajax({
                          type: 'POST',
                          data: obj,
                          url: api_url + `/api/${detail_name.api_name}`,
                          success: function(data) {
                            let temp_th='';
                            for(let a=0;a<detail_name.table_detail_culumn.length;a++){
                                temp_th+=`<th>${detail_name.table_detail_culumn[a].column_name}</th>`;
                            }
                            temp_th+=`
                            <th>編輯 <button type="button" class="btn btn-md btn-success" style="color:white;float:right;" onclick="add_detail_btn('${row_id}');">新增明細</button></th>
                            `;
                            
                            $target.closest("tr").next().find("div").append(`
                            <table class="table mt-3 table-striped" id="temp_table">
                                <thead class="table-warning" style="font-size:20px;">
                                   ${temp_th}
                                </thead>
                                <tbody></tbody>
                            </table>
                            `);
                            for(let i=0;i<data.length;i++){

                                let td_temp='';
                                td_temp+=`<tr id="process_detail_id_${data[i].id}">`;
                                for(let a=0;a<detail_name.table_detail_culumn.length;a++){
                                  td_temp+=`
                                  <td id="${detail_name.table_detail_culumn[a].column_id}_${data[i].id}">${(detail_name.table_detail_culumn[a].column_id=='status')?
                                      (data[i][detail_name.table_detail_culumn[a].column_id]=='Y')?'已作廢':'尚未作廢':
                                      (data[i][detail_name.table_detail_culumn[a].column_id]==null)?'':data[i][detail_name.table_detail_culumn[a].column_id]}</td>`;
                                }
                                if(detail_name.edit_button.length!=0){
                                    td_temp+=`<td>`;
                                    for(let a=0;a<detail_name.edit_button.length;a++){
                                        td_temp+=`
                                            <button type="button" class="${detail_name.edit_button[a].class}" style="${detail_name.edit_button[a].style}" onclick="${detail_name.edit_button[a].onclick}('${data[i][detail_name.edit_button[a].parameter_column_name]}');">${detail_name.edit_button[a].button_name}</button>
                                        `;
                                      }
                                      td_temp+=`
                                        <button type="button" id="btn_detail_status_${data[i].id}" class="btn btn-md ${(data[i].status=='N')?'btn-danger':'btn-success'}" style="color:white;" onclick="update_status('${data[i].id}');">${(data[i].status=='N')?'作廢':'復原'}</button>
                                      `
                                      td_temp+=`</td>`;
                                  }
                                  $('#temp_table tbody').append(td_temp);
                            }
                            $target.closest("tr").next().find("div").slideToggle();
                          },
                          error: function(xhr, status, error) {
                              let err = JSON.parse(xhr.responseText);
                          
                              Swal.fire({
                                  icon: 'error',
                                  title: 'Oops...',
                                  text: err.error_message
                              });
                          }
                      });

                
                  }                    
              });
              // globalSearch:true
              $("#table-list-head").fancyTable({		    
                          pagination: false,
                          perPage:20,				             
                      });
              $('.fancySearchRow').find("th:first").find("input").css('display','none');
              $('.fancySearchRow').find("th:last").find("input").css('display','none');
            }.bind(this, this.table_head,this.table_detail),
            error: function(xhr, status, error) {
                let err = xhr.responseText;
                //alert(err.error_message);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: err
                });
            }
        });
    }
    // // 監聽鼠標事件
    // _listenEvent() {
    //     // 輸入確定時發生跳頁
    //     this._input.addEventListener('change', e => Mediator.publish(MENU_INPUT_CHANGE, e.target.value));
    //     // 輸入框聚焦時清空先前內容
    //     this._input.addEventListener('focus', e => Mediator.publish(MENU_INPUT_FOCUS, e));
    // }
    _init() {
        // 渲染Table 樣板
        this._render_template();
        // 渲染Table head 值
        this._render_header();
        // 渲染Table head body 值
        this._render_head_body();
        // 選染選項
        // this._renderData();
        // // 監聽鼠標事件
        // this._listenEvent();
    }
}
