<template>
    <div>
        <div class="field">
            <label class="label">Where do you live?</label>
            <div class="control has-icons-left has-icons-right">
                <input
                    class="input is-success"
                    type="text"
                    name="living_place"
                    v-model="livingPlace"
                />
                <span class="icon is-small is-left">
                    <i class="fa-solid fa-house"></i>
                </span>
            </div>
        </div>
        <div class="field">
            <label class="label">Where do you work?</label>
            <div class="control has-icons-left has-icons-right">
                <input
                    class="input is-success"
                    type="text"
                    name="working_place"
                    v-model="workingPlace"
                />
                <span class="icon is-small is-left">
                    <i class="fa-solid fa-house"></i>
                </span>
            </div>
        </div>
        <label class="label">High School</label>
        <div v-for="(highschool, index) in highSchool" class="columns">
            <div class="field column">
                <label class="label">School Name:</label>
                <div class="control has-icons-left has-icons-right">
                    <input
                        class="input is-success"
                        type="text"
                        name="highschool_name"
                        v-model="highschool.school_name"
                    />
                    <span class="icon is-small is-left">
                        <i class="fa-solid fa-school"></i>
                    </span>
                </div>
            </div>
            <div class="field column">
                <label class="label">Start Year:</label>
                <div class="control">
                    <div class="select">
                        <select
                            class="year-select"
                            name="highschool_start"
                            v-model="highschool.start_year"
                        >
                            <option v-for="year in years">{{ year }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="field column">
                <label class="label">End Year:</label>
                <div class="control">
                    <div class="select">
                        <select
                            class="year-select"
                            name="highschool_start"
                            v-model="highschool.end_year"
                        >
                            <option v-for="year in years">{{ year }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="field column btn-delete-school">
                <button
                    @click="deleteHighSchool(index)"
                    class="button is-danger is-outlined"
                >
                    <span>Delete</span>
                    <span class="icon is-small">
                        <i class="fas fa-times"></i>
                    </span>
                </button>
            </div>
        </div>
        <div>
            <button
                @click="addHighSchoolInput"
                class="button btn-add-school is-link is-light"
            >
                <span>Add More Highschool</span>
                &nbsp;
                <span><i class="fa-solid fa-circle-plus"></i></span>
            </button>
        </div>
        <label class="label">University</label>
        <div v-for="university in university" class="columns">
            <div class="field column">
                <label class="label">What's your university?</label>
                <div class="control has-icons-left has-icons-right">
                    <input
                        class="input is-success"
                        name="university_name"
                        type="text"
                        v-model="university.school_name"
                    />
                    <span class="icon is-small is-left">
                        <i class="fa-solid fa-school"></i>
                    </span>
                </div>
            </div>
            <div class="field column">
                <label class="label">Start Year?</label>
                <div class="control">
                    <div class="select">
                        <select class="year-select" name="university_start" v-model="university.start_year">
                            <option v-for="year in years">{{ year }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="field column">
                <label class="label">Graduated Year?</label>
                <div class="control">
                    <div class="select">
                        <select class="year-select" name="university_gradueted" v-model="university.end_year">
                            <option v-for="year in years">{{ year }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="field column btn-delete-school">
                <button
                    @click="deleteUniversity(index)"
                    class="button is-danger is-outlined"
                >
                    <span>Delete</span>
                    <span class="icon is-small">
                        <i class="fas fa-times"></i>
                    </span>
                </button>
            </div>
        </div>
        <div>
            <button
                @click="addUniversityInput"
                class="button btn-add-school is-link is-light"
            >
                <span>Add More University</span>
                &nbsp;
                <span><i class="fa-solid fa-circle-plus"></i></span>
            </button>
        </div>
        <div class="field">
            <label class="label">I'm a ...</label>
            <div class="control">
                <div class="select">
                    <select name="gender" v-model="gender">
                        <option>Male</option>
                        <option>Female</option>
                        <option>Other</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="field is-grouped mt-3 columns is-justify-content-end">
            <button @click="saveInformation" class="button is-info is-1-desktop column is-full-mobile">
                Save
            </button>
        </div>
    </div>
</template>

<script>
import { updateUserProfile } from "../../api/user";
export default {
    props: ["user"],
    data() {
        return {
            years: [],
            livingPlace: null,
            workingPlace: null,
            highSchool: [],
            university: [],
            gender: null
        };
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
            this.gender = data.user_information.gender;
            this.highSchool = data.user_school?.flatMap((r) =>
                r.school_type == "SCHOOLE_HIGHSCHOOL" ? r : []
            );
            this.university = data.user_school?.flatMap((r) =>
                r.school_type == "SCHOOLE_UNIVERSITY" ? r : []
            );
        },
    },
    methods: {
        addHighSchoolInput() {
            this.highSchool.push({
                id: null,
                school_name: "",
                start_year: "",
                end_year: "",
            });
        },
        deleteHighSchool(index) {
            this.highSchool.splice(index, 1);
        },
        addUniversityInput() {
            this.university.push({
                id: null,
                school_name: "",
                start_year: "",
                end_year: "",
            });
        },
        deleteUniversity(index) {
            this.university.splice(index, 1);
        },
        async saveInformation() {
            let data = {
                living_place: this.livingPlace,
                working_place: this.workingPlace,
                gender: this.gender,
                university: this.university,
                highschool: this.highSchool
            }
            await updateUserProfile(data).then(result => {

            }).catch(err => {

            });
        },
    },
};
</script>
<style scoped>
.btn-add-school {
    width: 100%;
}

.btn-delete-school {
    justify-content: center;
    align-items: center;
    display: flex;
}
</style>
