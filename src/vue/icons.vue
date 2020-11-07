<template>
    <div>
        <!-- Icons -->
        <svg v-if="type=='logo'" aria-labelledby="title desc" version="1.0" xmlns="http://www.w3.org/2000/svg" width="80px" height="112px" viewBox="0 0 89.000000 127.000000" preserveAspectRatio="xMidYMid meet">
            <title>Serieslog</title>
            <desc>Use Serieslog to manage your series.</desc>
            <g transform="translate(0.000000,127.000000) scale(0.100000,-0.100000)" fill="#333333" stroke="none">
                <path d="M0 635 l0 -635 445 0 445 0 0 635 0 635 -445 0 -445 0 0 -635z m870
                0 l0 -615 -425 0 -425 0 0 615 0 615 425 0 425 0 0 -615z"/>
                <path fill="#e2506e" d="M318 1070 c-87 -26 -120 -73 -125 -180 -4 -64 -1 -82 19 -120 28 -55
                47 -66 239 -140 107 -41 162 -69 183 -90 31 -30 31 -31 31 -139 0 -95 -3 -112
                -20 -131 -26 -30 -92 -60 -132 -60 -27 0 -33 -4 -33 -21 0 -20 4 -21 55 -16
                73 7 134 42 162 92 19 34 23 55 23 133 0 162 -19 182 -256 272 -205 78 -224
                95 -224 202 0 113 47 168 145 168 28 0 35 4 35 20 0 17 -6 20 -37 19 -21 0
                -50 -4 -65 -9z"/>
                <path fill="#e2506e" d="M480 1061 c0 -15 10 -19 51 -23 89 -9 129 -55 129 -150 0 -55 1 -58
                25 -58 24 0 25 3 25 60 0 93 -36 145 -119 175 -62 22 -111 20 -111 -4z"/>
                <path fill="#e2506e" d="M182 350 c3 -50 9 -77 24 -97 30 -41 96 -74 159 -80 50 -5 55 -4 55
                14 0 15 -11 21 -58 31 -31 6 -68 19 -81 28 -31 22 -51 73 -51 129 0 42 -2 45
                -26 45 -26 0 -26 0 -22 -70z"/>
            </g>
        </svg>
        <!-- Caret left -->
        <svg v-if="type=='caret_left'" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-caret-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M10 12.796L4.519 8 10 3.204v9.592zm-.659.753l-5.48-4.796a1 1 0 0 1 0-1.506l5.48-4.796A1 1 0 0 1 11 3.204v9.592a1 1 0 0 1-1.659.753z"/>
        </svg>
        <!-- Caret right -->
        <svg v-if="type=='caret_right'" width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-caret-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M6 12.796L11.481 8 6 3.204v9.592zm.659.753l5.48-4.796a1 1 0 0 0 0-1.506L6.66 2.451C6.011 1.885 5 2.345 5 3.204v9.592a1 1 0 0 0 1.659.753z"/>
        </svg>
        <!-- Pen -->
        <svg v-if="type=='pen'" width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-pen" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M13.498.795l.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"/>
        </svg>
        <!-- Pen backgroundcolor -->
        <svg v-if="type=='pen_bc'" width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-pen background_color" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M13.498.795l.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"/>
        </svg>
        <!-- draggable -->
        <svg v-if="type=='draggable'" id="draggable" width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-grip-horizontal" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path d="M7 2a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zM7 5a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zM7 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm-3 3a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm-3 3a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
        </svg>
        <!-- note -->
        <svg v-if="type=='note'" width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-file-text" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M4 0h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H4z"/>
            <path fill-rule="evenodd" d="M4.5 10.5A.5.5 0 0 1 5 10h3a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zm0-2A.5.5 0 0 1 5 8h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zm0-2A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zm0-2A.5.5 0 0 1 5 4h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5z"/>
        </svg>
        <!-- delete -->
        <svg v-if="type=='delete'" width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
        </svg>
        <!-- add -->
        <svg v-if="type=='add'" id="add" width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-plus-square background_color" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
            <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
        </svg>
        <!-- login -->
        <svg v-if="type=='login'" id="login" width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-key background_color" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8zm4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5z"/>
            <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
        </svg>
        <!-- logout -->
        <svg v-if="type=='logout'" id="logout" width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-door-open background_color" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M1 15.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5zM11.5 2H11V1h.5A1.5 1.5 0 0 1 13 2.5V15h-1V2.5a.5.5 0 0 0-.5-.5z"/>
            <path fill-rule="evenodd" d="M10.828.122A.5.5 0 0 1 11 .5V15h-1V1.077l-6 .857V15H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117z"/>
            <path d="M8 9c0 .552.224 1 .5 1s.5-.448.5-1-.224-1-.5-1-.5.448-.5 1z"/>
        </svg>
    </div>

</template>

<script>
export default {
    props: [
        'type'
    ],
    components: {
        //comp,
    },
    data: function() {
        return {
        }
    },
    computed: {
    },
    mounted () {
    },
    methods: {
    },
}
</script>