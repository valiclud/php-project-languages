import { useState } from "react";
import { useMutation, useQueryClient } from "@tanstack/react-query";
import { addTranslatedtext } from "../api/translatedtextapi";
import Dialog from "@mui/material/Dialog";
import DialogActions from "@mui/material/DialogActions";
import DialogTitle from "@mui/material/DialogTitle";
import Button from "@mui/material/Button";
import type { TranslatedText } from "../types/types";
import TranslatedtextDialogContent from "./TranslatedtextDialogContent";

function AddTranslatedtext() {
  const [open, setOpen] = useState(false);
  const [translatedtext, setTranslatedtext] = useState<TranslatedText>({
    transtexttitle: "",
    transtexttext: "",
    transtextlanguage: "",
    revision: 0,
    idauthor: 0,
    idorigtext: 0,
  });
  const handleClickOpen = () => {
    setOpen(true);
  };

  const handleClose = () => {
    setOpen(false);
  };

  const numericFields = new Set(["revision", "idauthor", "idorigtext"]);

  const handleChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = event.target;
    setTranslatedtext({
      ...translatedtext,
      [name]: numericFields.has(name) ? Number(value) : value,
    });
  };
  const queryClient = useQueryClient();
  const { mutate } = useMutation({
    mutationFn: addTranslatedtext,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["translatedtexts"] });
    },
    onError: (err) => {
      console.error(err);
    },
  });
  const handleSave = () => {
    mutate(translatedtext);
    setTranslatedtext({
      transtexttitle: "",
      transtexttext: "",
      transtextlanguage: "",
      revision: 0,
      idauthor: 0,
      idorigtext: 0,
    });
    handleClose();
  };
  return (
    <>
      <Button onClick={handleClickOpen}>New Translated Text</Button>
      <Dialog open={open} onClose={handleClose}>
        <DialogTitle>New Translated Text</DialogTitle>
        <TranslatedtextDialogContent
          translatedtext={translatedtext}
          handleChange={handleChange}
        />
        <DialogActions>
          <Button onClick={handleClose}>Cancel</Button>
          <Button onClick={handleSave}>Save</Button>
        </DialogActions>
      </Dialog>
    </>
  );
}
export default AddTranslatedtext;
