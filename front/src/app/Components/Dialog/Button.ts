import { Button, ButtonProps, createPolymorphicComponent } from "@mantine/core";
import styled from "@emotion/styled";

const _StyledButton = styled(Button)`
    & + & {
        margin-left: 10px;
    }
`;

const StyledButton = createPolymorphicComponent<'button', ButtonProps>(_StyledButton);

export default StyledButton;