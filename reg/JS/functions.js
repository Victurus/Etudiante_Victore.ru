	function send_get(kn_area_id)
	{
		params = "knarea_id=" + kn_area_id
		request = new ajaxRequest()

		request.open("POST", "../reg/get_work_type.php", true)

		request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		request.setRequestHeader("Content-length", params.length)

		request.setRequestHeader("Connection", "close")

		request.onreadystatechange = function()
		{
			if(this.readyState == 4)
			{
				if(this.status == 200)
				{
					if(this.responseText != null)
					{
						document.getElementById('workt_p').innerHTML = this.responseText
					}
					else alert("Ошибка AJAX: Данные не получены")
				}
				else alert("Ошибка AJAX: " + this.statusText)
			}
		}

		request.send(params)

		function ajaxRequest()
		{
			try
			{
				var request = new XMLHttpRequest()
			}
			catch(e1)
			{
				try
				{
					request = new ActiveXObject("Msxml2.XMLHTTP")
				}
				catch(e2)
				{
					try
					{
						request = new ActiveXObject("Microsoft.XMLHTTP")
					}
					catch(e3)
					{
						request = false
					}
				}
			}
			return request
		}
	}

	

	function set_day(month)
	{
		born = document.getElementById('selector_date');

		count = 31;
		if (month == 2)
			count = 29;
		else 
			if(month == 4 || month == 6 || month == 9 || month == 11)
				count = 30;

		text = "<select name='date' size='1'>";
		text += "<option value='0'></option>";

		for(i = 1; i < count + 1; i++)
		{
			text += "<option value='" + i + "'>" + i + "</option>";
		}

		text += "</select>";
		born.innerHTML = text;
	}