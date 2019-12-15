@extends('layout.app')
@section('content')
    <head>
        <base href="https://demos.telerik.com/kendo-ui/grid/editing-inline">
        <style>html { font-size: 14px; font-family: Arial, Helvetica, sans-serif; }</style>
        <title>文章分類</title>
        <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2019.3.1023/styles/kendo.default-v2.min.css" />
        <style>
            .my-tag {
                margin-left: 5px;
                background: red;
                color: #fff;
            }
        </style>
        <script src="https://kendo.cdn.telerik.com/2019.3.1023/js/jquery.min.js"></script>
        <script src="https://kendo.cdn.telerik.com/2019.3.1023/js/kendo.all.min.js"></script>
    </head>

    <div id="example">
        <div id="grid"></div>
        <script>
            $(document).ready(function () {
                    dataSource = new kendo.data.DataSource({
                        transport: {
                            read: function(options) {
                                $.ajax({
                                    url: "{{ url("articles") }}",
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
                                var model = options.data;
                                var Tags = [];
                                for(var i=0; i < model.tags.length; i++)
                                {
                                    Tags[i] =  model.tags[i].id;
                                }
                                var data = {
                                    "_token":'{{ csrf_token() }}',
                                    "_method" : 'PUT',
                                    "id":model.id,
                                    "title":model.title,
                                    "content":model.content,
                                    "status":model.status ? 1 : 0,
                                    "category_id":model.category_id,
                                    "tags":Tags,
                                    "image":model.image,

                                };
                                //判斷model.select_category是否爲空
                                if(model.select_category != null) {
                                    data.category_id = model.select_category.id;
                                }
                                $.ajax({
                                    url: "{{ url("articles") }}",
                                    dataType:"json",
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

                            destroy: function(options) {
                                var model = options.data;
                                var data = {
                                    "_token": '{{ csrf_token() }}',
                                    "id":   model.id,
                                    "_method": 'DELETE'
                                };
                                $.ajax({
                                    url: "{{ url("articles") }}",
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

                            create: function (options) {
                                var model = options.data;
                                var ids = [];
                                for(var i=0; i < model.tags.length; i++)
                                {
                                    ids[i] =  model.tags[i].id;
                                }

                                var data =
                                {
                                    _token:'{{ csrf_token() }}',
                                    _method:'POST',
                                    "category_id": model.select_category.id,
                                    "title":model.title,
                                    "content":model.content,
                                    "status":model.status ? 1 : 0,
                                    "tag_ids": ids,
                                    "image":model.image,

                                };
                                $.ajax({
                                    url: "{{ url("articles") }}",
                                    dataType: "json",
                                    data:data,
                                    type:"POST",
                                    success: function(result) {
                                        options.success(result);
                                    },
                                    error: function(result) {
                                        if(result.status == 422)
                                        {
                                            alert(result.responseJSON.errors.title[0]);
                                        }
                                        options.error(result);
                                    }
                                });
                            },
                            parameterMap: function(options, operation) {
                                if (operation !== "read" && options.models) {
                                    return {models: kendo.stringify(options.models)};
                                }
                            }
                        },
                        // batch: true,
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
                                    title: {validation: { required: true } },
                                    content: { validation: { required: true, min: 1} },
                                    status:{required: true},
                                    tags: { editable: true, nullable: false, defaultValue: [] },
                                    image:{required: true},
                                    category_id: {type: "number"},
                                    category: { editable: false, nullable: true },
                                    created_at: { editable: false },
                                    updated_at:{ editable: false },
                                }
                            }
                        }
                    });

                $("#grid").kendoGrid({
                    dataSource: dataSource,
                    pageable: true,
                    height: 800,

                    toolbar: ["create"],
                    columns: [
                        {
                            field:"id",
                            title: "ID"
                        },
                        {
                            field: "title",
                            title: "標題"
                        },

                        {
                            field: "content",
                            title:"内容",
                            editor: function(container, options){
                                var input = $("<textarea/>");
                                input.attr("name", options.field);
                                input.appendTo(container);
                                input.kendoEditor({
                                    tools: [
                                        "bold",
                                        "italic",
                                        "underline",
                                        "createLink",
                                        "unlink",
                                        "insertImage"
                                    ]
                                });
                            }
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
                            field: "category_id",
                            title: "分類",
                            template: function(dataItem) {
                                //判斷name是否為空
                                if(dataItem.category==null){
                                    //如果為空,則顯示為空
                                    return "";
                                }
                                else {
                                    //如果不為空，則輸出
                                    return dataItem.category.name;
                                }
                            },
                            editor: function(container, options)
                            {
                                var input = $("<input/>");
                                input.attr("name", "select_category");
                                input.appendTo(container);

                                input.kendoDropDownList({
                                    dataTextField: "name",
                                    dataValueField: "id",
                                });

                                $.ajax({
                                    url: "{{ url("categorys") }}",
                                    dataType: "json",
                                    success: function(result) {
                                        var obj = input.data("kendoDropDownList");
                                        obj.setDataSource(result);
                                        obj.value(options.model.category_id)
                                    },
                                    error: function(result) {
                                        alert("")
                                    }
                                });
                            }
                        },
                        {
                            field:"tags",
                            title: "標籤",
                            template: function(dataItem) {
                                var value = "";
                                for (var i=0; i < dataItem.tags.length; i++)
                                {
                                    value += "<span class='my-tag'>"+ dataItem.tags[i].name + "</span>";
                                }

                                return value;

                            },
                            editor: function(container, options){
                                var input = $("<input/>");
                                input.attr("name", options.field);
                                input.appendTo(container);
                                input.kendoMultiSelect({
                                    placeholder: "Select products...",
                                    dataTextField: "name",
                                    dataValueField: "id",
                                    autoBind: false,
                                    dataSource: {
                                         //type:"json",
                                        serverFiltering: true,
                                        transport: {
                                            read: {
                                                url: "{{ url("tags")}}",
                                            }
                                        }
                                    },
                                });
                            }
                        },
                        {
                            field:"images",
                            title: "图片",
                            editor: function(container, options) {
                                var input = $("<input type='file'/>");
                                input.attr("name", options.field);
                                input.appendTo(container);
                            }
                        },
                        {
                            field: "created_at",
                            title:"創建時間" },
                        {
                            field: "updated_at",
                            title:"結束時間"
                        },
                        {
                            command: [
                                "edit",
                                "destroy",
                                {
                                    name: "upload",
                                    template: "<a class='k-button k-grid-upload'>上传</a>",
                                    click(e){
                                        $("<div id='window'></div>").kendoWindow({
                                            width: "300px",
                                            height: "200px",
                                            title: "About Alvar Aalto",
                                        }).data("kendoWindow").open();
                                    }
                                }
                            ],
                            width: 250,
                            title: "&nbsp;"
                        }],
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