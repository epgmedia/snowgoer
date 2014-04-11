function toggle(target, iNo)
{
	obj=document.getElementById(target+String(iNo));
	obj.style.display=( (obj.style.display=='') ? 'none' : '');
}// JavaScript Document