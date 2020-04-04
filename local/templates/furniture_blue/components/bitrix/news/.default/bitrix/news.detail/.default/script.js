var urlComplaint = {
    url: new URL(window.location.href),
}

urlComplaint.complaintId = urlComplaint.url.searchParams.get ('COMPLAINT_ID')
urlComplaint.complaintSuccess = urlComplaint.url.searchParams.get ('COMPLAINT_SUCCESS')
urlComplaint.complaintSent = urlComplaint.complaintSuccess === 'Y'
urlComplaint.complaintNotSent = urlComplaint.complaintSuccess === 'N'

var setComplaintText = function (message) {
    BX.adjust(BX('complaint-result'), { text: message })
}

var setComplaintParam = function (url) {
    var link = new URL(url)
    link.searchParams.set ('COMPLAINT', 'Y')
    return link
}

var sendAjax = function (url) {
    BX.ajax(
        {
            url: url,
            method: 'POST',
            dataType: 'json',
            onsuccess: function (data) {
                var message = data.idComplaint
                    ? BX.message('complaint_message') + data.idComplaint
                    : BX.message('error_message')
                setComplaintText(message)
            },
            onfailure: function () {
                setComplaintText(BX.message('error_message'))
            }
        }
    )
}

BX.ready(function () {

    if (urlComplaint.complaintSent) {
        setComplaintText(BX.message('complaint_message') + urlComplaint.complaintId)
    } else if (urlComplaint.complaintNotSent) {
        setComplaintText(BX.message('error_message'))
    }

    BX.bind(BX('link-complaint'), 'click', function (event) {
        event.preventDefault()
        if (BX.message('isAjax') === 'N') {
            window.location.href = setComplaintParam(event.target.href)
        } else {
            sendAjax(event.target.href)
        }
    })
})