<template>


    <div class='container py-5'>

        <FullCalendar :options='calendarOptions' ></FullCalendar>

        <!-- Single Event data Show Modal -->
        <b-modal v-model="eventDetailsModal" title="Event Details" hide-footer>

            <table class="table small">
                <tr>
                    <th>Title : </th>
                    <td v-if="clickCurrentEvetData.title">{{ clickCurrentEvetData.title }}</td>
                </tr>
                <tr>
                    <th>Start : </th>
                    <td v-if="clickCurrentEvetData.start" >{{ clickCurrentEvetData.start | moment("dddd, MMMM Do YYYY, h:mm:ss a") }}</td>
                </tr>
                <tr>
                    <th>End : </th>
                    <td v-if="clickCurrentEvetData.end">{{ clickCurrentEvetData.end | moment("dddd, MMMM Do YYYY, h:mm:ss a") }}</td>
                </tr>
                <tr>
                    <th>Remarks : </th>
                    <td v-if="clickCurrentEvetData.extendedProps">{{ clickCurrentEvetData.extendedProps.remarks }}</td>
                </tr>
                <tr>
                    <th>Created At : </th>
                    <td v-if="clickCurrentEvetData.extendedProps">{{ clickCurrentEvetData.extendedProps.created_at | moment("dddd, MMMM Do YYYY, h:mm:ss a") }}</td>
                </tr>
            </table>
        </b-modal>


        <!-- Data Store Modal -->
        <b-modal v-model="eventDataStoreModal" title="Event Details" hide-footer>

          <form @submit.prevent="storeCurrentEventData()">

            <div class="form-group">
                <label for="event_name">Event Title</label>
                <b-form-input type="text" id="event_name" class="form-control" v-model="form.title" size="sm" placeholder="Enter Event Title" :class="{ 'is-invalid': form.errors.has('title') }"></b-form-input>
                <div class="small text-danger" v-if="form.errors.has('title')"
                                v-html="form.errors.get('title')" />
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <b-form-datepicker v-model="form.start_date" today-button reset-button close-button
                            locale="en" placeholder="YYYY-MM-DD" autocomplete="off" size="sm"
                            :hide-header="datePickerHeader"
                            :date-format-options="{ year: 'numeric', month: 'long', day: 'numeric' }" :class="{ 'is-invalid': form.errors.has('start_date') }">
                        </b-form-datepicker>
                        <div class="small text-danger" v-if="form.errors.has('start_date')"
                                v-html="form.errors.get('start_date')" />

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <b-form-datepicker v-model="form.end_date" today-button reset-button close-button locale="en"
                            placeholder="YYYY-MM-DD" autocomplete="off" size="sm" :hide-header="datePickerHeader"
                            :date-format-options="{ year: 'numeric', month: 'long', day: 'numeric' }" :class="{ 'is-invalid': form.errors.has('end_date') }">
                        </b-form-datepicker>
                        <div class="small text-danger" v-if="form.errors.has('end_date')"
                                v-html="form.errors.get('end_date')" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Start_Time">Start Time</label>
                        <b-form-timepicker id="Start_Time" v-model="form.start_time" now-button reset-button locale="en" size="sm" :class="{ 'is-invalid': form.errors.has('start_time') }">
                        </b-form-timepicker>
                        <div class="small text-danger" v-if="form.errors.has('start_time')"
                                v-html="form.errors.get('start_time')" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="End_Time">End Time</label>
                        <b-form-timepicker id="End_Time" v-model="form.end_time" now-button reset-button locale="en" size="sm" :class="{ 'is-invalid': form.errors.has('end_time') }">
                        </b-form-timepicker>
                        <div class="small text-danger" v-if="form.errors.has('end_time')"
                                v-html="form.errors.get('end_time')" />
                    </div>
                </div>
            </div>

            <div class="row">
               <div class="col-md-12">
                <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <b-form-textarea id="remarks" v-model="form.remarks" size="sm" placeholder="Enter Event Remarks" :class="{ 'is-invalid': form.errors.has('remarks') }"></b-form-textarea>
                    <div class="small text-danger" v-if="form.errors.has('remarks')"
                                v-html="form.errors.get('remarks')" />
                </div>
               </div>
            </div>


         

             <b-form-group v-if="form.progress">
                    <b-progress :value="form.progress.percentage" variant="success" striped animated>
                    </b-progress>
                </b-form-group>

                <b-form-group v-if="!form.progress">
                    <b-button type="submit" class="btn-block" variant="primary">Create</b-button>
                </b-form-group>

            </form>
            



        </b-modal>


    </div>

</template>


<script>
    import FullCalendar from '@fullcalendar/vue'
    import dayGridPlugin from '@fullcalendar/daygrid'
    import timeGridPlugin from '@fullcalendar/timegrid'
    import interactionPlugin from '@fullcalendar/interaction'

    // vform
    import Form from 'vform';
    import axios from 'axios'

    import { BPopover } from 'bootstrap-vue'
    
 
    export default {
        components: {
            FullCalendar // make the <FullCalendar> tag available
        },
        data: function () {
            return {

                eventDetailsModal: false,
                clickCurrentEvetData: '',

                eventDataStoreModal: false,
                datePickerHeader: true,
               
                 // Form
                form: new Form({
                    title: '',
                    start_date: '',
                    start_time: '00:01:00',
                    end_date: '',
                    end_time: '23:59:00',
                    remarks: ''
                }),




                calendarOptions: {
                    plugins: [
                        dayGridPlugin,
                        timeGridPlugin,
                        interactionPlugin // needed for dateClick
                    ],
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    initialView: 'dayGridMonth',
                    editable: true,
                    selectable: true,
                    selectMirror: true,
                    dayMaxEvents: true,
                    weekends: true,
                    select: this.handleDateSelect,
                    eventClick: this.handleEventClick,
                    // eventsSet: this.handleEvents,
                    themeSystem: 'bootstrap',
                    weekNumbers: true,
                   
                    events: "",
                    eventBackgroundColor: "rgb(24, 130, 42)",
                    eventBorderColor: "red",
                    displayEventTime : false,
                    // For Mouse Hover
                    eventDidMount: this.onEventRender


                },

              
            }
        },
        methods: {

             onEventRender: function (args) {
                //console.log(this.$moment(args.event.start).format("MMM Do, h:mm:ss a"))

                let titleStr = args.event.title
                let contentStr = this.$moment(args.event.start).format("MMM Do, h:mm:ss a") + " - " + this.$moment(args.event.start).format("MMM Do, h:mm:ss a");

                new BPopover({propsData: {
                    title: titleStr,
                    content: contentStr,
                    placement: 'auto',
                    boundary: 'scrollParent',
                    boundaryPadding: 3,
                    delay: 50,
                    offset: 0,
                    triggers: 'hover',
                    html: true,
                    target: args.el,
                    variant:"info",
                    customClass:"custom-tooltrip"
                }}).$mount()
            },

            // handleEvents(events) {
            //     // this.currentEvents = events
            //     console.log('All events dd', events)
            // },


            async getDataAsync() {
              try {
                const response = await axios.get('/index');
                // Data assign to calendar
                this.calendarOptions.events = response.data
                console.log(response.data);
              } catch (error) {
                console.error(error);
              }
            },


          getDirectData(){


            



            //  this.calendarOptions.initialEvents =  [{
            //                 title: 'event1',
            //                 start: '2021-11-01',
            //                 color: 'green'
            //             },
            //             {
            //                 title: 'event2',
            //                 start: '2021-11-05',
            //                 end: '2021-11-11',
            //                 color: 'red'
            //             },
            //             {
            //                 title: 'event3',
            //                 start: '2021-11-07T12:30:00',
            //                 allDay: false,
            //             },
            //         ]

            axios.get('/index').then(response=>{
              
             //this.initialEvents = response.data

            this.calendarOptions.initialEvents =  [{
                            title: 'event1',
                            start: '2021-11-01',
                            color: 'green'
                        },
                        {
                            title: 'event2',
                            start: '2021-11-05',
                            end: '2021-11-11',
                            color: 'red'
                        },
                        {
                            title: 'event3',
                            start: '2021-11-07T12:30:00',
                            allDay: false,
                        },
                    ]

                    console.log("getDirectData", response.data)

            }).catch(error=>{
              console.log(error)
            })

          },
           

            // Mouse Hover 
            eventMouseEnter(calEvent) {

                $(calEvent.el).tooltip({
                    title: calEvent.event.title
                });

                // console.log('eventMouseEnter', calEvent.event.title)
            },


            handleDateSelect(selectInfo) {

                //select Previous Date
                if (this.$moment().diff(selectInfo.startStr, 'days') > 0) {
                    alert("Can Not Select Previous Date");
                    return false;
                }

              // Generate a new date for manipulating in the next step
              let endDate = new Date(selectInfo.endStr.valueOf());
              endDate.setDate(endDate.getDate() -1); // One days passed
              let newEndDate = new Date(endDate);
              //let actualEndDate =  this.$moment(newEndDate).format("Y-MM-DD")
              
              let strDate = JSON.stringify(newEndDate)
              let actualEndDate = strDate.slice(1,11)

              // // Assign Data
              this.form.start_date = selectInfo.startStr;
              this.form.end_date = actualEndDate;
              
            
              // Modal Show
               this.eventDataStoreModal = true;

               console.log('selectInfo', selectInfo, selectInfo.startStr, selectInfo.endStr, newEndDate, actualEndDate)
            },


            // Single Event Data Show
            handleEventClick(clickInfo) {
              // Modal Show
              this.eventDetailsModal = true;
              // Asign Current event data
              this.clickCurrentEvetData = clickInfo.event;

              console.log('clickInfo', clickInfo.event.title)

            },

          


            // store Current Event Data DB
            storeCurrentEventData() {

              this.form.post('/store').then(response=>{

                console.log(response)
                // Refresh Calendar
                this.getDataAsync();
                // Modal Hide
                this.eventDataStoreModal = false;

              }).catch(error=>{
                console.log(error)
              })


            },



        },



     
        created(){
        
          // Data fetch from DB
          this.getDataAsync();
        
        }


    }

</script>




<style lang='css'>

    .fc .fc-toolbar.fc-header-toolbar{
        font-size: .8em !important;
    }
    @media (max-width: 767.98px) {
        .fc .fc-toolbar.fc-header-toolbar {
            display: block;
            text-align: center;
        }

        .fc-header-toolbar .fc-toolbar-chunk {
            display: block;
        }
    }
    td .fc-day-fri {
        background-color: #f0c2be !important;
    }

    .fc .fc-daygrid-day.fc-day-today {
        background-color: var(--fc-today-bg-color, rgba(251, 242, 107, 0.99));
    }

    .custom-tooltrip{
        font-weight: bold;
        color: black !important;
        /* font-size: 18px; */
    }

  

</style>
