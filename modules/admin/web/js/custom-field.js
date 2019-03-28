$(document).ready(function(){

    $('.delet-game-link').on('click',function() {
        if (confirm('Confirm the deletion of the game')) {
            let link = $(this).data('link');
            window.location = link;
        }
    });

    $('#add-field').on('click',function() {
        $('#content-custom-field').append(createField());
    });

    $('#content-custom-field').on('click', function() {
        $('#content-custom-field').siblings('.help-block').empty();
    });


    $('#content-custom-field').find('.del-field').on('click', deleteBlock);
    $('#content-custom-field').find('.s-type select').change(selectType);



    $('#payment-button').on('click', function() {
        let arry_field = createArryField();
        if(arry_field) {
            $('#input-filed-ar').val(JSON.stringify(arry_field));
            $('#form-game').submit();
            //console.log(JSON.stringify(arry_field));
        } else {
            $('#content-custom-field').siblings('.help-block').text('Fill in all required fields.');
        }
    });

    function createField () {
        let count = $('#content-custom-field').find('.field-custom').length;
        let div = `<div class="field-custom clearfix">
                    <span class="del-field" ><i class="fas fa-times"></i></span>
                    <div class="col-sm-1 number" >${count+1}</div>
                    <div class="col-sm-11 s-type">
                    <div class="col-sm-3 ">
                    <label class="control-label mb-1 req">Field type</label>
                    <select class="form-control-sm form-control select-type">
                    <option value="vib" >Field type</option>
                    <option value="select" >Select</option>
                    <option value="input" >Input</option><option value="checkbox">Checbox</option>
                    </select></div><div class="col-sm-3 "><label class="control-label mb-1 req">Name</label>
                    <input class="form-control inp-name" ></div>
                    <div class="col-sm-3 "><label class="control-label mb-1 req">Title</label>
                    <input class="form-control inp-title" ></div>
                    <div class="col-sm-3 "><label class="control-label mb-1">Class</label>
                    <input class="form-control inp-class" ></div>
                    </div><div class="col-sm-10 col-sm-offset-1 tex-area-input"></div>
                    </div>`;
        div = $(div);
        div.find('.del-field').on('click', deleteBlock);
        div.find('.s-type select').change(selectType);
        return div;
    }

    function deleteBlock(e) {
        if(confirm('Confirm the deletion field')) {
            $(this).parents('.field-custom').remove();
            let fields = $('#content-custom-field').find('.field-custom');
            $.map(fields,function (field, index) {
                $(field).find('.number').html(index+1);
            });
            $('#content-custom-field').siblings('.help-block').empty();
        }
    }

    function selectType(event) {
        let content ="", res = $(event.target);
        if(res.val() == 'select') {
            content = select();  
        } else {
            res.parents('.field-custom').find('.tex-area-input').empty();
        }
        res.parents('.field-custom').find('.tex-area-input').empty();
        res.parents('.field-custom').find('.tex-area-input').append(content);
    }

    function select() {
        return `<div class="texarea"><label class="control-label mb-1 req">Option</label>
                <span>Enter the value "opions" through the separator ";" for example ( apple;pear;peach )</span>
                <textarea row="6" class="form-control option-field" ></textarea></div>`;
    }

    function createArryField() {
        let fields = $('#content-custom-field').find('.field-custom');
        let valid = true, arry_field = [];

        $.map(fields,function (elemnt, index) {
            if (valid) {
                let field = $(elemnt);
                let filed_obj = {};
                let type = field.find('.select-type').val().trim();
                let name = field.find('.inp-name').val().trim();
                let title = field.find('.inp-title').val().trim();
                let clas = field.find('.inp-class').val().trim();

                if((type == 'vib') || (name == "") || (title == "")) {
                    valid = false;
                }
            
                filed_obj.type = type;
                filed_obj.name = name;
                filed_obj.title = title;
                filed_obj.class = clas;
                if(type == 'select') {
                    let option_text = field.find('.option-field').val().trim();
                    if (option_text == "") {
                        valid = false;
                    } else {
                        filed_obj.options = option_text.split(';');
                    }
                } else if (type == 'checkbox') {
                    filed_obj.options = ["1"];
                }
                arry_field.push(filed_obj);
            } 
        });
        if (valid) {
            return arry_field;
        }
        return valid;
    }

});