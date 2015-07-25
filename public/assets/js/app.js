(function() {
    // 标签随机颜色
    var tagColors = ['am-badge-primary', 'am-badge-secondary', 'am-badge-success', 'am-badge-warning', 'am-badge-danger'];
    /*
     $(".am-panel-bd .am-badge").each(function() {
     var index = parseInt(Math.random() * tagColors.length);
     $(this).addClass(tagColors[index]);
     });
    */
    $(".am-panel-bd .am-badge").hover(function() {
        if ($(this).hasClass('ac-has-color')) {
            return true;
        }
        $(this).addClass('ac-has-color')
            .addClass(tagColors[parseInt(Math.random() * tagColors.length)])
            .addClass('am-animation-scale-up');
    }, function() {
        //for (var index in tagColors) {
        //    $(this).delay(3000).removeClass(tagColors[index]);
        //}
    });

    //$(".am-panel-bd .am-badge").each(function() {
    //    $(this).addClass('am-animation-delay-' + (parseInt(Math.random() * 5) + 1))
    //        .addClass('am-animation-scale-up');
    //});

    // 找不到页面消息，展示照片
    if ($(".ac-msg-sorry").length) {
        var max_photo_id = 27;
        var photo_url = 'http://source.aicode.cc/photograph/';
        var item_pools = [];
        while (item_pools.length < 5) {
            var _index = parseInt(Math.random() * max_photo_id);
            if (_index == 0) {
                continue;
            }
            if (item_pools.indexOf(_index) == -1) {
                item_pools.push(_index);
            }
        }

        var img_list = '';
        for (var item in item_pools) {
            img_list += '<li><img src="' + photo_url + 'IMG_' + item_pools[item] + '.jpg"/></li>'
        }

        $(".ac-msg-sorry").append('<div class="am-slider am-slider-default" data-am-flexslider>' +
        '<ul class="am-slides">' + img_list + '</ul></div>');
    }

    // 搜索 - 使用百度站内搜索
    if ($("form[role=search]").length) {
        $("form[role=search]").on('submit', function() {
            var input = $('form[role=search] input[name=wd]');
            input.val(input.val() + ' site:aicode.cc');
            return true;
        });
    }

    // 鼠标经过Logo自动展开侧边栏
    $(".am-topbar-brand").hover(function() {
        $(this).find('a').click();
    });

    // about 图标效果
    var icon_styles = ['am-primary', 'am-secondary', 'am-success', 'am-warning', 'am-danger'];
    $(".ac-about a").hover(function() {
        var index = parseInt(Math.random() * icon_styles.length)
        $(this).addClass(icon_styles[index]);
    }, function() {
        for (var index in icon_styles) {
            $(this).removeClass(icon_styles[index]);
        }
    });

    // 更新最新的bloglist
    if ($('.am-panel .blog-list').length) {
        var url = 'api/blog/related-' + $('span.related-tags').attr('data-tags') + '.json';
        $.getJSON(url, function(data) {
            if (data.status == 1) {
                var list = '';
                for (var index in data.posts) {
                    list += '<li><a href="article/' + data.posts[index]['id'] + '.html">' + data.posts[index]['title'] + '</a></li>';
                }
                if (list.length > 0) {
                    $(".am-panel .blog-list").addClass('am-animation-fade am-animation-delay-2').html(list);
                }
            } else {
                console.log(data);
            }
        });
    }
})();