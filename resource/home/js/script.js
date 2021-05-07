
	var oTab=document.getElementById("cen_right_top");
	var aH3=oTab.getElementsByTagName("h3");
	var aDiv=oTab.getElementsByClassName("div111");
	console.log(aDiv);
	for(var i=0;i<aH3.length;i++)
	{
		aH3[i].index=i;
		aH3[i].onmouseover=function()
		{
			for(var i=0;i<aH3.length;i++)
			{
				aH3[i].className="";
				aDiv[i].style.display="none";
			}
			this.className="active";
			aDiv[this.index].style.display="block";
		}
	}
