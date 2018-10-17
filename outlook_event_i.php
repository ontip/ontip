<?php 
//This is the most important coding. 
header("Content-Type: text/Calendar"); 
header("Content-Disposition: inline; filename=filename.ics"); 
echo "BEGIN:VCALENDAR\n"; 
echo "PRODID:-//Microsoft Corporation//Outlook 12.0 MIMEDIR//EN\n"; 
echo "VERSION:2.0\n"; 
echo "METHOD:PUBLISH\n"; 
echo "X-MS-OLK-FORCEINSPECTOROPEN:TRUE\n"; 
echo "BEGIN:VEVENT\n"; 
echo "CLASS:PUBLIC\n"; 
echo "CREATED:20091109T101015Z\n"; 
echo "DESCRIPTION:How 2 Guru Event\\n\\n\\nEvent Page\\n\\nhttp://www.myhow2guru.com\n"; 
echo "DTEND:20120908T040000Z\n"; 
echo "DTSTAMP:20121109T093305Z\n"; 
echo "DTSTART:20120908T003000Z\n"; 
echo "LAST-MODIFIED:20091109T101015Z\n"; 
echo "LOCATION:Anywhere have internet\n"; 
echo "PRIORITY:5\n"; 
echo "SEQUENCE:0\n"; 
echo "SUMMARY;LANGUAGE=en-us:How2Guru Event\n"; 
echo "TRANSP:OPAQUE\n"; 
echo "UID:040000008200E00074C5B7101A82E008000000008062306C6261CA01000000000000000\n"; 
echo "X-MICROSOFT-CDO-BUSYSTATUS:BUSY\n"; 
echo "X-MICROSOFT-CDO-IMPORTANCE:1\n"; 
echo "X-MICROSOFT-DISALLOW-COUNTER:FALSE\n"; 
echo "X-MS-OLK-ALLOWEXTERNCHECK:TRUE\n"; 
echo "X-MS-OLK-AUTOFILLLOCATION:FALSE\n"; 
echo "X-MS-OLK-CONFTYPE:0\n"; 
//Here is to set the reminder for the event. 
echo "BEGIN:VALARM\n"; 
echo "TRIGGER:-PT1440M\n"; 
echo "ACTION:DISPLAY\n"; 
echo "DESCRIPTION:Reminder\n"; 
echo "END:VALARM\n"; 
echo "END:VEVENT\n"; 
echo "END:VCALENDAR\n"; 
?> 
