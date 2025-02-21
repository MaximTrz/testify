import React from "react";
import { Box, CircularProgress } from "@mui/material";

const Loader: React.FC = () => {
    return (
        <Box
            sx={{
                display: "flex",
                justifyContent: "center",
                alignItems: "center",
                height: "65vh",
                width: "100%",
            }}
        >
            <CircularProgress />
        </Box>
    );
};

export default Loader;
