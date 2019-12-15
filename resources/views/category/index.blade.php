@extends('layout.app')
@section('content')
    <head>
        <base href="https://demos.telerik.com/kendo-ui/grid/editing-popup">
        <style>html { font-size: 14px; font-family: Arial, Helvetica, sans-serif; }</style>
        <title></title>
        <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2019.3.1023/styles/kendo.default-v2.min.css" />

        <script src="https://kendo.cdn.telerik.com/2019.3.1023/js/jquery.min.js"></script>
        <script src="https://kendo.cdn.telerik.com/2019.3.1023/js/kendo.all.min.js"></script>

    </head>
    <div id="example">
        {{ csrf_field() }}
        <div id="grid"></div>
        <script>
            $(document).ready(function () {

                    dataSource = new kendo.data.DataSource({
                        transport: {
                            read: function(options) {
                                $.ajax({
                                    url: "{{ url("categorys") }}",
                                    dataType: "json",
                                    success: function(result) {
                                        options.success(result);
                                    },
                                    error: function(result) {
                                        options.error(result);
                                    }
                                });
                            },

                            update:function(options){
                                var model = options.data.models[0];
                                var data = {
                                    "_token":'{{ csrf_token() }}',
                                    "_method":"PUT",
                                    "id":model.id,
                                    "name":model.name,
                                    "status":model.status ? 1 : 0,
                                };
                              $.ajax({
                                  url: "{{ url("categorys") }}",
                                  dataType:"json",
                                  type:"put",
                                  data: data,
                                  success: function(result) {
                                      options.success(result);
                                  },
                                  error: function(result) {
                                      options.error(result);
                                  }
                              });
                            },

                            create: function (options) {
                                var model =options.data.models[0];
                                var data = {
                                    "_token":'{{ csrf_token() }}',
                                    "_method":"POST",
                                    "name":model.name,
                                    "status": model.status ? 1 : 0,
                                };

                                $.ajax({
                                    url: "{{ url("categorys") }}",
                                    dataType: "json",
                                    data:data,
                                    type:"POST",
                                    success: function(result) {
                                        options.success(result);
                                    },
                                    error: function(result) {
                                        if(result.status == 422)
                                        {
                                            alert(result.responseJSON.errors.name[0]);
                                        }
                                        options.error(result);
                                    }
                                });
                            },
                            destroy: function(options) {
                                var model = options.data.models[0];
                                var data = {
                                    "_method": "DELETE",
                                    "_token":'{{ csrf_token()}}',
                                    "id":model.id,
                                    "name":model.name,
                                    "status":model.status,
                                };

                                $.ajax({
                                    url: "{{ url("categorys") }}",
                                    dateType:"json",
                                    type:"POST",
                                    data: data,
                                    success: function(result) {
                                        options.success(result);
                                    },
                                    error: function(result) {
                                        options.error(result);
                                    }
                                });
                            },
                            parameterMap: function(options, operation) {
                                if (operation !== "read" && options.models)
                                {
                                    var model = options.models[0]
                                    model._token = '{{ csrf_token() }}';
                                    return model;
                                    // return { models: kendo.stringify(options.models) };
                                }
                            }
                        },
                        batch: true,
                        pageSize: 20,
                        schema: {
                            errors: function(response) {
                                //console.log("errors as function")
                                return response.errors;
                            },
                            model: {
                                id: "id",
                                fields: {
                                    id: { field: "id" , editable: false, nullable: true },
                                    name: { validation: { required: true } },
                                    status:{required: true},
                                    created_at: { editable: false },
                                    updated_at:  { editable: false  },

                                }
                            }
                        }
                    });

                $("#grid").kendoGrid({
                    dataSource: dataSource,
                    pageable: true,
                    height: 550,
                    toolbar: ["create"],
                    columns: [
                        {
                            field:"id",
                            title: "id"
                        },
                        {
                            field: "name",
                            title: "名字",
                        },
                        {
                            field: "status",
                            title:"狀態",
                            template: function(ops){
                                if(ops.status == 1){
                                   return "开启" ;
                                }
                                else {
                                  return "关闭" ;
                                }
                            },
                            editor: function(container, options) {
                                var input = $("<input type='checkbox'/>");
                                input.attr("name", options.field);
                                input.appendTo(container);
                                input.kendoSwitch();
                                 setTimeout(() => {
                                    input.data("kendoSwitch").check(options.model.status);
                                 },10);
                            }
                        },
                        {
                            field: "created_at",
                            title:"創建時間"
                        },
                        {
                            field: "updated_at",
                            title:"結束時間"
                        },
                        { command: ["edit", "destroy"], title: "&nbsp;", width: "250px" }],
                    editable: "popup"
                });
            });

            function customBoolEditor(container, options) {
                var guid = kendo.guid();
                $('<input class="k-checkbox" id="' + guid + '" type="checkbox" name="Discontinued" data-type="boolean" data-bind="checked:Discontinued">').appendTo(container);
                $('<label class="k-checkbox-label" for="' + guid + '">​</label>').appendTo(container);
            }
        </script>
    </div>


@endsection


