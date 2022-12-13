<template>
    <div>
        <div class="field">
            <label class="label">Where do you live?</label>
            <div class="control has-icons-left has-icons-right">
                <input class="input is-success" type="text" name="living_place" v-model="livingPlace">
                <span class="icon is-small is-left">
                    <i class="fa-solid fa-house"></i>
                </span>
            </div>
        </div>
        <div class="field">
            <label class="label">Where do you work?</label>
            <div class="control has-icons-left has-icons-right">
                <input class="input is-success" type="text" name="working_place" v-model="workingPlace">
                <span class="icon is-small is-left">
                    <i class="fa-solid fa-house"></i>
                </span>
            </div>
        </div>
        <div v-for="highschool in highSchool" class="columns">
            <div class="field column">
                <label class="label">What's your high school?</label>
                <div class="control has-icons-left has-icons-right">
                    <input class="input is-success" type="text" name="highschool_name" value="">
                    <span class="icon is-small is-left">
                        <i class="fa-solid fa-school"></i>
                    </span>
                </div>
            </div>
            <div class="field column">
                <label class="label">Start Year?</label>
                <div class="control">
                    <div class="select">
                        <select class="year-select" name="highschool_start">
                            <option v-for="year in years">{{ year }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="field column">
                <label class="label">Graduated Year?</label>
                <div class="control">
                    <div class="select">
                        <select class="year-select" name="highschool_gradueted">
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="field column">
                <label class="label">What's your university?</label>
                <div class="control has-icons-left has-icons-right">
                    <input class="input is-success" name="university_name" type="text" value="">
                    <span class="icon is-small is-left">
                        <i class="fa-solid fa-school"></i>
                    </span>
                </div>
            </div>
            <div class="field column">
                <label class="label">Start Year?</label>
                <div class="control">
                    <div class="select">
                        <select class="year-select" name="university_start">
                        </select>
                    </div>
                </div>
            </div>
            <div class="field column">
                <label class="label">Graduated Year?</label>
                <div class="control">
                    <div class="select">
                        <select class="year-select" name="university_gradueted">

                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="field">
            <label class="label">I'm a ...</label>
            <div class="control">
                <div class="select">
                    <select name="gender">
                        <option>Male</option>
                        <option>Female</option>
                        <option>Other</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="fields is-grouped mt-3 columns is-justify-content-end">
            <button class="button is-info is-1-desktop column is-full-mobile mt-2">
                <p>Save</p>
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: ['user'],
    data() {
        return {
            years: Array(),
            livingPlace: null,
            workingPlace: null,
            highSchool: [],
            university: []
        }
    },
    mounted() {
        let currentYear = new Date().getFullYear() + 10;
        for (let i = currentYear; i >= 1970; i--) {
            this.years.push(i);
        }
    },
    watch: {
        user(data) {
            this.livingPlace = data.user_information.living_place;
            this.workingPlace = data.user_information.working_place;
            this.highSchool = data.user_schools?.map((r) => r.school_type == 'SCHOOLE_HIGHSCHOOL');
            this.university = data.user_schools?.map((r) => r.school_type == 'SCHOOLE_UNIVERSITY');
        }
    }
}
</script>