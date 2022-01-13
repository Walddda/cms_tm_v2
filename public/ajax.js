
$(document).ready(function(){

    $('.deleteBtn').click(function (e) {
        e.preventDefault();
    
        itemId = $(this).attr('id');
    
        $.ajax({
    
            url: '/del/Quote',
            data: {'entityId':itemId},
            method: 'post',
            success: function (data, reponse) {
    
             if(data == 'good' ){
                location.reload();
             }
            },
            error: function () {
            },
        });
    
    });

    $('.deleteBtnM').click(function (e) {
        e.preventDefault();
    
        itemId = $(this).attr('id');
    
        $.ajax({
    
            url: '/del/Movie',
            data: {'entityId':itemId},
            method: 'post',
            success: function (data, reponse) {
    
             if(data == 'good' ){
                location.reload();
             }
            },
            error: function () {
            },
        });
    });

    $("#editForm").submit(function (e) {
        console.log($(this).serialize())
        e.preventDefault();    
        $.ajax({
            url: '/editSub',
            data: $(this).serialize(),
            method: 'post',
            success: function (data, reponse) {
                console.log(data)
            },
            error: function () {
            },
        });
    });
    // $("#addForm").submit(function (e) {
    //     console.log($(this).serialize())
    //     e.preventDefault();    
    //     $.ajax({
    //         url: '/add',
    //         data: $(this).serialize(),
    //         method: 'post',
    //         success: function (data, reponse) {
    //             console.log(data)
    //             console.log('added')
    //             window.location.assign('/');
    //         },
    //         error: function () {
    //         },
    //     });
    // });

    $('#movieTrigger').click(function (e) {
        e.currentTarget.classList.add('triggerActive')
        $('#quoteTrigger')[0].classList.remove('triggerActive')
        $('#addMovie')[0].style.display ='contents';
        $('#addQuote')[0].style.display ='none';
        $('#ent')[0].value = 'TM'
        // console.log(e);
        // console.log('e');
    });
    $('#quoteTrigger').click(function (e) {
        e.currentTarget.classList.add('triggerActive')
        console.log($('#movieTrigger'));
        $('#movieTrigger')[0].classList.remove('triggerActive')
        $('#addMovie')[0].style.display ='none';
        $('#addQuote')[0].style.display ='contents';
        $('#ent')[0].value = 'Ori'
        // console.log('e');
    });
    $('#searchSubmit').click(function (e){
        val = $('#searchValue')[0].value;
        console.log($('#searchValue')[0])
        window.location.assign('/search/'+val);
    })
})