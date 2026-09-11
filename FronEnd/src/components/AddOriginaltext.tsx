import { useState } from "react";
import { useMutation, useQueryClient } from "@tanstack/react-query";
import { addOriginaltext } from "../api/originaltextapi";
import Dialog from "@mui/material/Dialog";
import DialogActions from "@mui/material/DialogActions";
import DialogTitle from "@mui/material/DialogTitle";
import type { OriginalText } from "../types/types";
import OriginaltextDialogContent from "./OriginaltextDialogContent";

function AddOriginaltext() {
  const [open, setOpen] = useState(false);
  const [originaltext, setOriginaltext] = useState<OriginalText>({
    origtextauthor: "",
    origtexttitle: "",
    origtexttext: "",
    origtextimage: "",
    origtextcentury: 0,
    idplace: 0,
    idlanguage: 0,
    idauthor: 0,
  });
  const handleClickOpen = () => {
    setOpen(true);
  };

  const handleClose = () => {
    setOpen(false);
  };
  // Addoriginaltext.tsx
  const handleChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    setOriginaltext({
      ...originaltext,
      [event.target.name]: event.target.value,
    });
  };
  const queryClient = useQueryClient();
  const { mutate } = useMutation({
    mutationFn: addOriginaltext,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["originaltexts"] });
    },
    onError: (err) => {
      console.error(err);
    },
  });
  const handleSave = () => {
    mutate(originaltext);
    setOriginaltext({
      origtextauthor: "",
      origtexttitle: "",
      origtexttext: "",
      origtextimage: "",
      origtextcentury: 0,
      idplace: 0,
      idlanguage: 0,
      idauthor: 0,
    });
    handleClose();
  };
  return (
    <>
      <button onClick={handleClickOpen}>New Original Text</button>
      <Dialog open={open} onClose={handleClose}>
        <DialogTitle>New Original Text</DialogTitle>
        <OriginaltextDialogContent
          originaltext={originaltext}
          handleChange={handleChange}
        />
        <DialogActions>
          <button onClick={handleClose}>Cancel</button>
          <button onClick={handleSave}>Save</button>
        </DialogActions>
      </Dialog>
    </>
  );
}
export default AddOriginaltext;
