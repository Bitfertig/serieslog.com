/**
 * slidercontrol
 */

var slidercontrol = {
    data: function () {
        return {
            slidercontrol_dragging: false,
            //slidercontrol_drag_x: 0,
            slidercontrol_circle_pos: 8,
        }
    },
    methods: {
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
            console.log(event.clientX);
            console.log(document.getElementById('circle_test').getBoundingClientRect().left);
            }
        }
    },
    mounted() {
        window.addEventListener('mouseup', this.stopDrag);
    }
}
export default slidercontrol;
