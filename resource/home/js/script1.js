
    var oTab1 = $('#cen_right_top1');
    var aH31=$("#cen_right_top1>h3");
    var aDiv1=$("#cen_right_top1>div");
    for(var i=0;i<aH31.length;i++)
    {
        debugger
        aH31[i].index=i;
        aH31[i].on('mouseover',function () {
            debugger
            for(var i=0;i<aH31.length;i++)
            {
                aH31[i].className="";
                aDiv1[i].style.display="none";
            }
            this.className="active";
            aDiv1[this.index].style.display="block";
        })
        // aH31[i].onmouseover=function()
        // {
        //     debugger
        //     for(var i=0;i<aH31.length;i++)
        //     {
        //         aH31[i].className="";
        //         aDiv1[i].style.display="none";
        //     }
        //     this.className="active";
        //     aDiv1[this.index].style.display="block";
        // }
    }