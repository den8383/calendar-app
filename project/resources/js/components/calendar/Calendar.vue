<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Calendar</div>
                        {{userName}}さんのカレンダー
                        <a href="/plan"><button>予定</button></a>
                    <div class="card-body">
                        {{String(isNaN('s'))}}
                        {{year}}年
                        {{month}}月
                        <button v-on:click="changeMonth(-1)">Back</button>
                        <button v-on:click="changeMonth(1)">Next</button>
                                    
                        <table border="1">
                            <tr v-for="oneweek in monthList">
                                <td v-for="oneday in oneweek">
                                    <a href="/plan" id="today" v-if="year==todaysYear && month==todaysMonth+1 && oneday==todaysDate">{{oneday}}
                                        <form action="/send" method="post">
                                            <input type="hidden" name="_token" :value="csrf">
                                            <input type="hidden" name="name" :value="userName">
                                            <input type="hidden" name="id" :value="String(year)+String(month)+String(oneday)">
                                            <input type="hidden" name="u_id" :value="String(userId)">
                                            <input type="hidden" name="dateData" :value="String(year)+String(month)+String(oneday)">
                                            <input type="submit" value="追加">
                                        </form>
                                    </a">
                                    <a href="/plan" id="day" v-else-if="daylist.includes(oneday) || isNaN(oneday)">{{oneday}}
                                    </a>
                                    <div v-else>{{oneday}}
                                    <form action="/send" method="post">
                                        <input type="hidden" name="_token" :value="csrf">
                                        <input type="hidden" name="name" :value="userName">
                                        <input type="hidden" name="id" :value="String(year)+String(month)+String(oneday)">
                                        <input type="hidden" name="u_id" :value="String(userId)">
                                        <input type="hidden" name="dateData" :value="String(year)+String(month)+String(oneday)">
                                        <input type="submit" value="追加">
                                    </form>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="sass" scoped>
#today
    color: blue
    background-color: yellow

#day
    color: black
</style>

<script>
    var changeMonthCount = 0
    export default {
        props: {
            userName: String,
            userId: String
        },
        el: '#calendar',
        data: function() {
            this.changeMonth(0)
            this.getToday()
            return{
                monthList: this.changeMonth(0).monthList,
                year: this.changeMonth(0).year,
                month: this.changeMonth(0).month,
                date: this.changeMonth(0).date,
                daylist:this.changeMonth(0).daylist,
                setMonthCount: this.changeMonth(0).setMonthCount,
                today:this.getToday().todaysYear,
                todaysYear:this.getToday().todaysYear,
                todaysMonth:this.getToday().todaysMonth,
                todaysDate:this.getToday().todaysDate,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        },
        methods: {
            getToday: function(){
                var today = new Date()
                var todaysYear = today.getFullYear()
                var todaysMonth = today.getMonth()
                var todaysDate = today.getDate()
                return{
                    today,
                    todaysYear,
                    todaysMonth,
                    todaysDate
                }
            },
            changeMonth: function (valueChangeMonth) {
                changeMonthCount += valueChangeMonth
                var setMonthCount = changeMonthCount
                 {
                    var date = new Date()
                    date.setMonth(date.getMonth() + setMonthCount)
                    const year = date.getFullYear()
                    const month = date.getMonth()+1
                    const startDate = new Date(year,month-1, 1)
                    const endDate = new Date(year,month, 0)
                    const endDateCount = endDate.getDate()
                    const startDay = startDate.getDay()
                    const endDay = endDate.getDay()
                    const dateList = [...Array(endDateCount).keys()].map(i => ++i)
                    const lastMonthEndDate = new Date(year, month -1, 0)
                    const lastMonthEndDateCount = lastMonthEndDate.getDate()
                    var monthList = []
                    var weekList = []
                    var dayCount = 0
                    var beforeMonthDay = []
                    var daylist = ['日', '月', '火', '水', '木', '金', '土']
                    
                    monthList.push(daylist)
                    for (let step = 0; step < startDay; step++){
                        dateList.unshift('前'+String((lastMonthEndDateCount - step)))
                    }
                    for (var step = 1; step < 7 - endDay; step++){
                        dateList.push('次'+String(step))
                    }

                    for (var dt of dateList){
                        dayCount++;
                        weekList.push(dt)
                        if (dayCount%7==0){
                            monthList.push(weekList)
                            weekList = []
                        }
                    }
                    monthList.push(weekList)
                    this.$set(this,"monthList",monthList)
                    this.$set(this,"year",year)
                    this.$set(this,"month",month)
                    this.$set(this,"date",date)
                    console.log(changeMonthCount)
                    return {
                        monthList,
                        year,
                        month,
                        date,
                        daylist,
                        setMonthCount
                    }
                }
              }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
