<template>
    <div>
        <figure>
            <img/>
        </figure>
    </div>
</template>

<script>
export default {
    data() {
        return {
            avatar: ""
        };
    },
    props: ['user'],
    watch: {
        user(data) {
            this.livingPlace = data.user_information.living_place;
            this.workingPlace = data.user_information.working_place;
            this.highSchool = data.user_school?.flatMap((r) => r.school_type == 'SCHOOLE_HIGHSCHOOL' ? r : []);
            this.university = data.user_school?.flatMap((r) => r.school_type == 'SCHOOLE_UNIVERSITY' ? r : []);
        }
    }
}
</script>