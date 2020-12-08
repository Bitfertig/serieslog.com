/**
 * slidercontrol
 */

var slidercontrol = {
    data: function () {
        return {
            mousedowntimer_start: null,
            slidercontrol_mousedowntimer: false,
            slidercontrol_dragging: false,
            slidercontrol_circle_pos: 8,
        }
    },
    methods: {
        mousedownTimer(){
            var mousedowntimer_end = new Date();
            // time difference in ms
            var  mousedowntimer_timeDiff = mousedowntimer_end - this.mousedowntimer_start;
            // get seconds
            var seconds = Math.round( mousedowntimer_timeDiff % 100000000);
        
            $(".time").text(seconds);
        },

        startDrag() {
            this.slidercontrol_dragging = true;
            this.slidercontrol_circle_pos = 8;
        },
        stopDrag() {
            this.slidercontrol_dragging = false;
            this.slidercontrol_circle_pos = 8;
        },
        doDrag(event) {
            if (this.slidercontrol_dragging) {
            this.slidercontrol_circle_pos = event.clientX - ( document.getElementById('circle_test').getBoundingClientRect().left + 42);
            console.log(document.getElementById('circle_test').getBoundingClientRect().left);
            }
        }
    },
    mounted() {
        window.addEventListener('mouseup', this.stopDrag);
    }
}
export default slidercontrol;
