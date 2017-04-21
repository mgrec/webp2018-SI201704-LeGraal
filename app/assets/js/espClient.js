/*!
 * fastshell
 * Fiercely quick and opinionated front-ends
 * https://HosseinKarami.github.io/fastshell
 * @author Hossein Karami
 * @version 1.0.5
 * Copyright 2017. MIT licensed.
 */
/**
 * Created by azerty on 20/04/2017.
 */
$(".listHeader ul li").first().click(function(){
    if(!$(this).hasClass('active')){
        $(this).toggleClass('active');
        $(".listHeader ul li").last().toggleClass('active');
        $('#listFacture').toggleClass('hidden');
        $('#listPlan').toggleClass('hidden');
    }
});

$(".listHeader ul li").last().click(function(){
    if(!$(this).hasClass('active')){
        $(this).toggleClass('active');
        $(".listHeader ul li").first().toggleClass('active');
        $('#listFacture').toggleClass('hidden');
        $('#listPlan').toggleClass('hidden');
    }
});