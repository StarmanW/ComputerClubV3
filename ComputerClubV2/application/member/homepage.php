<?php
    $pageTitle = "Homepage";
    include "../templates/header.php";
?>
<section class="features13 cid-qBOcIYl8xg mbr-parallax-background" id="features13-f" data-rv-view="11966">
    <div class="mbr-overlay" style="opacity: 0.4; background-color: rgb(35, 35, 35);">
    </div>
    <div class="container">
        <h2 class="mbr-section-title pb-3 mbr-fonts-style display-1"><br>Welcome<?php if (isset($_SESSION['userName']) === true) {echo ", ".$_SESSION['userName'];}?>!<br><br></h2>
        <div class="media-container-row container">
            <!--- CSS Overriden -->
            <div class="card col-12 col-md-6 p-5 m-3 align-center col-lg-4" id="hover_image" onclick="window.open('memberList.php');">
                <div class="card-img">
                    <img src="../assets/images/mbr-720x1080.jpg" alt="Mobirise" title="" media-simple="true">
                </div>
                <h4 class="card-title py-2 mbr-fonts-style display-2" id="card_text_1">Member</br>List</h4>
                <p class="mbr-text mbr-fonts-style display-7"></p>
            </div>
            <div class="card col-12 col-md-6 p-5 m-3 align-center col-lg-4" id="hover_image" onclick="window.open('eventList.php');">
                <div class="card-img">
                    <img src="../assets/images/jumbotron2.jpg" alt="Mobirise" media-simple="true">
                </div>
                <h4 class="card-title py-2 mbr-fonts-style display-2" id="card_text_2">Event</br>List</h4>
                <p class="mbr-text mbr-fonts-style display-7"></p>
            </div>
            <div class="card col-12 col-md-6 p-5 m-3 align-center col-lg-4" id="hover_image" onclick="window.open('collaboratorList.php');">
                <div class="card-img">
                    <img src="../assets/images/mbr-2-1620x1080.jpg" alt="Mobirise" title="" media-simple="true">
                </div>
                <h4 class="card-title py-2 mbr-fonts-style display-2" id="card_text_3">Collaborator</br>List</h4>
                <p class="mbr-text mbr-fonts-style display-7"></p>
            </div>
        </div>
    </div>
</section>
<section class="timeline1 cid-qBOcTO5gLd mbr-parallax-background" id="timeline1-h" data-rv-view="11969">
    <div class="mbr-overlay" style="opacity: 0.7; background-color: rgb(35, 35, 35);">
    </div>
    <div class="container align-center">
        <h2 class="mbr-section-title pb-3 mbr-fonts-style display-1">Upcoming Events</h2>
        <div class="container timelines-container" mbri-timelines="">
            <%
            //Get all event records and sort by date
            ArrayList<Event> eventList = eventDA.selectAllEventsList();
                Collections.sort(eventList);

                int eventListSize = eventList.size();
                if (eventListSize > 0) {

                //Add 3 records with date after current date
                ArrayList<Event> upcomingEventList;
                    upcomingEventList = new ArrayList<Event>(3);
                        Date todayDate = new Date();

                        SimpleDateFormat parser = new SimpleDateFormat();
                        String comparisonFormat = "yyyy-MM-dd";
                        parser.applyPattern(comparisonFormat);

                        int addedCount = 0;
                        for (int i = 0; i < eventListSize; i++) {
                        Date eventDate = parser.parse(eventList.get(i).getEventDate());

                        if (todayDate.before(eventDate) == true) {
                        upcomingEventList.add(eventList.get(i));
                        addedCount++;
                        if (addedCount >= 3) {
                        break;
                        }
                        }
                        }

                        int upcomingEventListSize = upcomingEventList.size();

                        //Parse all selected record's date
                        Date[] upcomingDateList;
                        upcomingDateList = new Date[3];
                        for (int i = 0; i < upcomingEventListSize; i++) {
                        upcomingDateList[i] = parser.parse(upcomingEventList.get(i).getEventDate());
                        }

                        String displayFormat = "d MMMM yyyy";
                        parser.applyPattern(displayFormat);

                        String[] dispUpcomingDateList;
                        dispUpcomingDateList = new String[3];
                        for (int i = 0; i < upcomingEventListSize; i++) {
                        dispUpcomingDateList[i] = parser.format(upcomingDateList[i]);
                        }

                        //Parse all selected record's start and end time
                        String _24HrFormat = "HH:mm";
                        parser.applyPattern(_24HrFormat);

                        Date[] upcomingStartTimeList;
                        upcomingStartTimeList = new Date[3];
                        Date[] upcomingEndTimeList;
                        upcomingEndTimeList = new Date[3];
                        for (int i = 0; i < upcomingEventListSize; i++) {
                        upcomingStartTimeList[i] = parser.parse(upcomingEventList.get(i).getEventStartTime());
                        upcomingEndTimeList[i] = parser.parse(upcomingEventList.get(i).getEventEndTime());
                        }

                        String _12HrFormat = "hh:mm aa";
                        parser.applyPattern(_12HrFormat);

                        String[] dispUpcomingStartTimeList;
                        dispUpcomingStartTimeList = new String[3];
                        String[] dispUpcomingEndTimeList;
                        dispUpcomingEndTimeList = new String[3];
                        for (int i = 0; i < upcomingEventListSize; i++) {
                        dispUpcomingStartTimeList[i] = parser.format(upcomingStartTimeList[i]);
                        dispUpcomingEndTimeList[i] = parser.format(upcomingEndTimeList[i]);
                        }

                        %>

                        <%for (int i = 0; i < upcomingEventListSize; i++) {
                        if (i % 2 == 0) {
                        %>
                        <div class="row timeline-element reverse separline">
                            <%} else {%>
                            <div class="row timeline-element separline">
                                <%}%>
                                <div class="timeline-date-panel col-xs-12 col-md-6  align-left">
                                    <div class="time-line-date-content">
                                        <p class="mbr-timeline-date mbr-fonts-style display-5"><%=dispUpcomingDateList[i]%>&nbsp;
                                            <br>
                                        </p>
                                    </div>
                                </div>
                                <span class="iconBackground"></span>
                                <div class="col-xs-12 col-md-6 align-left">
                                    <div class="timeline-text-content">
                                        <h4 class="mbr-timeline-title pb-3 mbr-fonts-style display-5"><%=upcomingEventList.get(i).getEventName()%></h4>
                                        <h4 class="mbr-timeline-text mbr-fonts-style display-7">
                                            <table border="0" cellpadding="10" style="text-align:left; " >
                                                <tbody>
                                                <tr>
                                                    <td>What: </td>
                                                    <td><%=upcomingEventList.get(i).getEventTypeString()%></td>
                                                </tr>
                                                <tr>
                                                    <td>When: </td>
                                                    <td><%=dispUpcomingStartTimeList[i]%> to <%=dispUpcomingEndTimeList[i]%></td>
                                                </tr>
                                                <tr>
                                                    <td>Where: </td>
                                                    <td><%=upcomingEventList.get(i).getEventLocation()%></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            <%}%>
                            <%} else if (eventListSize <= 0) {%>
                            <h2 class="mbr-section-title pb-3 mbr-fonts-style display-1"></br></br>No Upcoming Events Right Now</h2>
                            <%}%>
                        </div>
        </div>
    </div>
</section>
<?php require "../templates/footer.php"?>