function update_dungeon_status(member, type)
{

    console.log(member.info.id);
    $(".dungeon-name").each(function ()
    {
        console.log("Element:"+$(this).data("id"));
        if ($(this).data("id") === member.info.id)
        {
            if(type == "add")
            {
                var now = new Date();
                var last_active = new Date(member.info.last_seen);

                console.log("Now:" + now);
                console.log("ActiveLast:" + last_active);

                last_active.setTime(last_active.getTime() + (5*60*1000) - (6*60*60*1000));

                console.log("Adjusted:" + last_active);

                if(last_active > now)
                {
                    $(this).css('color', 'green');
                }
                else
                {
                    $(this).css('color', 'yellow');
                }
            }
            else
            {
                $(this).css('color', 'red');
            }

        }
    });

}

