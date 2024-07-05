(function() {
    function Form(config) {
        this.form = document.querySelector(config['formId']);
        this.elementsConfig = config['elementsConfig'];
        console.log(config);
    
        this.initEventListeners();
    }
    
    Form.prototype.initEventListeners = function() {
        this.form.addEventListener('submit', (function(e) {
            e.preventDefault();
    
            let form = e.currentTarget;
            let checked = true;
            let messages = [];
    
            for (let element of this.elementsConfig) {
                let targetName = element['attributes']?.['name'];
    
                if (!targetName) {
                    continue;
                }
    
                let target = form.querySelector('input[name="' + targetName + '"]')
    
                if (!target) {
                    continue;
                }
    
                if (element['required'] && !target.value.length) {
                    messages.push('Field ' + target.name + ' is required');
    
                    checked = false;
                }
    
                if (element['checkers']?.length) {
                    for (let checker of element['checkers']) {
                        if (!(new RegExp(checker[0]).test(target.value))) {
                            messages.push(checker[1]);
    
                            checked = false;
                        }
                    }
                }
            }
            
            if (checked) {
                form.submit();

                return true;
            }

            (messages.length && alert(messages.join('\n')));
        }).bind(this));
    };

    window.Form = Form;
}());