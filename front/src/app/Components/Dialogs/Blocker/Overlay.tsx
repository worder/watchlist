import BlockerOverlay from '../../BlockerOverlay/BlockerOverlay';
import { connect } from 'react-redux';
import { isVisible } from './overlaySelectors';
import { RootState } from '../../../../store/store';

const Overlay = connect((state: RootState) => ({
    isVisible: isVisible(state),
}))(BlockerOverlay);

export default Overlay;
