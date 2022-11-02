import { useToast, POSITION } from 'vue-toastification';
import ProgressBarComponent from '../components/Common/ProgressBarComponent.vue';

const toast = useToast();

export default {
    uploadProgressBar(context, progress) {
        if (progress > 0) {
            context.commit('updateProgressUpload', progress);
            toast({
                component: ProgressBarComponent,
                props: progress
            }, {
                timeout: false,
                position: POSITION.TOP_CENTER
            });
        }

        if (progress == 100) {
            context.commit('updateProgressUpload', 0);
        }
    }
};